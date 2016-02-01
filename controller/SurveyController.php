<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainPage
 *
 * @author anthony.poon
 */
class SurveyController extends PrivilegedZone {

    //put your code here
    public $dbconnection;
    public $table;

    function __construct() {
        parent::__construct();
        $this->dbconnection = new DbConnector();
    }
    
    function defaultAction($param = NULL) {
        if (empty($this->user->appraisee) && empty($this->user->countersignee)){
            header('Location: survey?action=renderForm&r=self&u='.$this->user->username.'&uid='.$this->user->availiblePeriod['uid']);
        } else {
            $param["u"] =  $this->user->username;
            $param["uid"] =  $this->user->activeUid;
            $param["r"] =  "self";
            $this->menuSelectView($param);
        }
    }

    function testing($param = null) {
        do {
            $statement = "SELECT username FROM pa_user WHERE user_password = 'password'";
            $query = $this->dbconnection->prepare($statement);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (!empty($result['username'])) {
                $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                         .'0123456789');
                shuffle($seed);
                $rand = '';
                foreach (array_rand($seed, 7) as $k) $rand .= $seed[$k];
                var_dump($rand);
                $statement = "UPDATE pa_user SET user_password = :str WHERE username = :user";
                $query = $this->dbconnection->prepare($statement);
                $query->bindParam(":user", $result['username']);
                $query->bindParam(":str", $rand);
                $query->execute();
            }
        } while ($result);
    }
    
    function renderForm($param = null) {
        $checking = $this->paramChecking($param);
        $this->extraCSS = array("survey/form.css", "jquery-ui.css");
        $this->content = "survey/form.php";
        $this->header = "surveyHeader.php";
        $this->extraJS = array("jquery-2.1.3.js", "jquery-ui.js", "form-logic.js");
        $data = new FormData($param['u'], $param['uid']);
        if ($data->isNewForm()) {
            $data->renderNewForm($param['u']);
        }
        
        $formDetail = $data->getFormData();
        
        if ($param['r'] === 'app') {            
            $data->updateData('is_recently_changed_by_self', FALSE);
        }
        if (isset($_SESSION['isInstructionShown']) || $param['r'] == 'review') {
            $param['shouldShowInstuction'] = False;
        } else {            
            $param['shouldShowInstuction'] = True;
            $_SESSION['isInstructionShown'] = True;
        }
        
        $param["data"] = $formDetail;
        $this->view($param);
    }
    
    function renderPrintView($param = null) {
        $checking = $this->paramChecking($param);
        $this->extraCSS = "form_print_view.css";
        $this->content = "survey/formPrintView.php";
        $this->header = "printViewHeader.php";
        $data = new FormData($param['u'], $param['uid']);
        if ($data->isNewForm()) {
            throw new Exception("Username not found or User have not filled in survey yet");
        }
        
        $formDetail = $data->getFormData();        
        $this->view($param);
    }

    function getFormData($param = null) {
        $checking = $this->paramChecking($param);
        $data = new FormData($param['u'], $param['uid']);
        header('Content-Type: application/json');
        echo json_encode($data->getFormData());
    }

    function postFormData($param = null) {
        $checking = $this->paramChecking($param);
        
        // Injection vul. get to it later.
        if (isset($_POST['fieldName']) && isset($_POST['value'])) {
            $data = new FormData($param['u'], $param['uid']);
            $data->updateData($_POST['fieldName'], $_POST['value']);
        }
        
        if (isset($_POST['dataArray'])) {
            foreach ($_POST['dataArray'] as $fieldName => $value) {
                $data = new FormData($param['u'], $param['uid']);
                $data->updateData($fieldName, $value);
            }
        }
    }

    function clearA($param = null) {
        $checking = $this->paramChecking($param);
        $data = new FormData($param['u'], $param['uid']);
        $data->clearPartAEntry($param['qid']);
        $data->updateData("part_a_overall_score", NULL);
        $data->updateData("part_a_total", NULL);
        $data->updateData("part_a_b_total", NULL);
    }
    
    function addPartAItem($param = null){
        $checking = $this->paramChecking($param);
        $data = new FormData($param['u'], $param['uid']);
        $data->updateData($_POST['fieldName'], $_POST['value']);
        $data->updateData("part_a_overall_score", NULL);
        $data->updateData("part_a_total", NULL);
        $data->updateData("part_a_b_total", NULL);
        echo json_encode(array("success" => TRUE));
    }
            
    function clearD($param = null) {
        $checking = $this->paramChecking($param);
        $data = new FormData($param['u'], $param['uid']);
        $data->clearPartDEntry($param['qid']);
    }
    
    function formChange($param = null) {
        $checking = $this->paramChecking($param);
        $data = new FormData($param['u'], $param['uid']);
        if ($param['r'] === 'self') {
            $data->updateData('is_final_by_self', FALSE);
            $data->updateData('is_final_by_appraiser', FALSE);
            $data->updateData('is_recently_changed_by_self', TRUE);
        } else if ($param['r'] === 'app') {
            $data->updateData('is_final_by_appraiser', FALSE);
            $data->updateData('is_recently_changed_by_app', TRUE);
        }
    }

    function finish($param = null) {
        $checking = $this->paramChecking($param);
        $form = new FormData($param['u'], $param['uid']);        
        if ($param['r'] === 'self') {
            $form->updateData('is_final_by_self', TRUE);
            $form->updateData('is_recently_changed_by_self', TRUE);
        } else if ($param['r'] === 'app') {
            $form->updateData('is_final_by_appraiser', TRUE);
        } else if ($param['r'] === 'counter1') {
            $form->updateData('is_final_by_counter1', TRUE);
        } else if ($param['r'] === 'counter2') {
            $form->updateData('is_final_by_counter2', TRUE);
        }
        $this->extraCSS = array("finish.css", "jquery-ui.css");
        $this->header = "surveyHeader.php";
        $this->extraJS = array("jquery-2.1.3.js", "jquery-ui.js");
        $this->content = "finish.php";
        $this->view();
    }
    
    function confirmAfterFinish($param) {
        $checking = $this->paramChecking($param);
        $data = new FormData($param['u'], $param['uid']);
        $result = $data->getFormData(TRUE);
        
        if (!$result['is_final_by_self'] && !$result['is_final_by_appraiser']) {
            throw new Exception("Form not submitted by both party. Cannnot confirm.");
        }

        if ($param['r'] === 'self') {
            if ($result['is_confirmed_by_app_after_final']) {
                $data->updateData('is_confirmed_by_self_after_final', TRUE);
                //$data->updateData('is_locked', TRUE);
            } else {
                $data->updateData('is_confirmed_by_self_after_final', TRUE);
            }
        } else if ($param['r'] === 'app') {
            if ($result['is_confirmed_by_self_after_final']) {
                $data->updateData('is_confirmed_by_app_after_final', TRUE);
                //$data->updateData('is_locked', TRUE);
            } else {
                $data->updateData('is_confirmed_by_app_after_final', TRUE);
            }
        }
    }
    
    function menuSelectView($param = NULL) {
        $this->content = "survey/selectForm.php";
        $this->header = "surveyHeader.php";
        $this->extraCSS = "select_form.css";
        $this->extraJS = array("jquery-2.1.3.js", "jquery-ui.js");
        parent::view($param);
    }
    
    function subSelect($param = null) {
        If ($param['r'] === 'app') {
            foreach ($this->user->appraisee as $username => $fullname) {
                $data = new FormData($username, $param['uid']);
                $result = $data->getFormData();
                $param['selection'][$username]['fullName'] = $fullname;
                $param['selection'][$username]['isChanged'] = $result['is_recently_changed_by_self'];
                $param['selection'][$username]['completeness'] = $result['is_final_by_appraiser'];
            }
            $this->content = 'survey/subSelect.php';
            $this->header = "surveyHeader.php";
            $this->extraCSS = "select_form.css";
            $this->view($param);
        } else If ($param['r'] === 'counter') {
            foreach ($this->user->countersignee as $username => $role) {
                $data = new FormData($username, $param['uid']);
                $result = $data->getFormData();
                $param['selection'][$username]['fullName'] = $this->user->countersigneeFullName[$username];
                $param['selection'][$username]['role'] = $role;
                $param['selection'][$username]['status'] = $result['is_final_by_self'] && $result['is_final_by_appraiser'];
            }
            $this->content = 'survey/subSelect.php';
            $this->header = "surveyHeader.php";
            $this->extraCSS = "select_form.css";
            $this->extraJS = array("jquery-2.1.3.js", "jquery-ui.js");
            $this->view($param);
        } else {
            throw new Exception('Illegal parameter provided.');
        }
    }

    function periodSelect($param = null) {
        If (($param['r'] === 'self') || ($param['r'] === 'app') || ($param['r'] === 'counter')) {
            $this->content = 'survey/periodSelect.php';
            $this->header = "surveyHeader.php";
            $this->extraCSS = "select_form.css";
            $this->extraJS = array("jquery-2.1.3.js", "jquery-ui.js");
            $param['u'] = $this->user->username;
            $param['selection'] = $this->user->availiblePeriod;
            $this->view($param);
        } else {
            throw new Exception('Illegal parameter provided.');
        }
    }

    function view($param = null) {
        if (empty($this->content)) {
            if (empty($this->user->appraisee) && empty($this->user->countersignee)){
                header('Location: survey?action=renderForm&r=self&u='.$this->user->username.'&uid='.$this->user->availiblePeriod['uid']);
            }
        }        
        if (!empty($param)) {
            parent::view($param);
        } else {
            parent::view();
        }
    }

    function paramChecking($param) {
        //Only check if user is using the valid role, cant check if user have the right to modify the data node
        if ((empty($param['u']) || empty($param['uid'])) || empty($param['r'])) {
            throw new Exception('Missing parameter');
        }
        
        if ($param['r'] === 'self' && ($this->user->username != $param['u'])){
            throw new Exception('Illegal parameter: Access Denied (Not appraisee)');
        }
        
        if ($param['r'] === 'app' && !array_key_exists($param['u'], $this->user->appraisee)){
            throw new Exception('Illegal parameter: Access Denied (Not appraiser)');
        }

        if ($param['r'] === 'counter' && !array_key_exists($param['u'], $this->user->countersignee)){
            throw new Exception('Illegal parameter: Access Denied (Not countersigner)');
        }
        
        if ($param['r'] == 'admin' && (!$this->user->isAdmin)){
            throw new Exception('Illegal parameter: Access Denied (Not Admin)');
        }
        
        return true;
    }
    
    function viewSelfPreviosSurvey($param = NULL){
        $checking = $this->paramChecking($param);
        $this->extraCSS = array("survey/self-survey-period-select.css", "jquery-ui.css");
        $this->content = "survey/selfPeriodPelect.php";
        $this->header = "surveyHeader.php";
        $this->extraJS = array("jquery-2.1.3.js", "jquery-ui.js", "form-logic.js");
        $param["data"] = $this->user->getSelfPreviousUid();
        $this->view($param);
    }
}
