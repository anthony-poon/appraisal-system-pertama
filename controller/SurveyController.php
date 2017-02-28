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
    public $table;
    
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
    
    function renderForm($param = null) {
        $checking = $this->paramChecking($param);
        $this->extraCSS = array("survey/form.css", "jquery-ui.css");
        $this->content = "survey/form.php";
        $this->header = "surveyHeader.php";
        $this->extraJS = array("form-logic.js");
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
        $userFactory = new UserBatchOperator();
        $param["available_uid"] = $userFactory->getParticipatedPeriod($this->user->username);
        $param["data"] = $formDetail;
        $this->view($param);
    }
    
    function viewOnly($param = null) {
        $this->extraCSS = array("survey/form.css", "jquery-ui.css");
        $this->content = "survey/form_view_only.php";
        $this->header = "surveyHeader.php";
        $param["data"] = $data->getFormData();
        $this->view($param);
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
        $statusBeforeSubmittion = $form->getStatus();
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
        $status = $form->getStatus();
        $userOperator = new UserBatchOperator();
        
        $mailer = new PhpMailerFactory();
        
        // Prevent F5 reload or revisit 
        $isStatusChanged = ($statusBeforeSubmittion["is_final_by_self"] !== $status["is_final_by_self"]) || ($statusBeforeSubmittion["is_final_by_appraiser"] !== $status["is_final_by_appraiser"]);
        if (($isStatusChanged) && ($status["is_final_by_self"] xor $status["is_final_by_appraiser"])) {            
            if ($param["r"] === "self") {
                $to[] = $userOperator->getEmailByUsername($this->user->username);
                $to[] = $userOperator->getEmailByUsername($this->user->appraiser);
                $mailer->appraiseeSubmmitEmail($this->user->fullName, $userOperator->getFullNameByUsername($this->user->appraiser), $to);
            } else if ($param['r'] === 'app') {
                $to[] = $userOperator->getEmailByUsername($this->user->username);
                $to[] = $userOperator->getEmailByUsername($param['u']);
                $mailer->appraiserSubmmitEmail($this->user->fullName, $userOperator->getFullNameByUsername($param['u']), $to);
            }            
        } else if (($isStatusChanged) && ($status["is_final_by_self"] && $status["is_final_by_appraiser"])) {
            if ($param["r"] === "self") {
                $to[] = $userOperator->getEmailByUsername($this->user->username);
                $to[] = $userOperator->getEmailByUsername($this->user->appraiser);
                $mailer->formLockEmail($userOperator->getFullNameByUsername($param['u']), $userOperator->getFullNameByUsername($this->user->appraiser), $to);
            } else if ($param["r"] === "app"){
                $to[] = $userOperator->getEmailByUsername($this->user->username);
                $to[] = $userOperator->getEmailByUsername($param['u']);
                $mailer->formLockEmail($userOperator->getFullNameByUsername($param['u']), $userOperator->getFullNameByUsername($this->user->username), $to);
            }
        }        
        $this->extraCSS = array("finish.css", "jquery-ui.css");
        $this->header = "surveyHeader.php";
        $this->content = "finish.php";
        $this->view();
    }
    
    function menuSelectView($param = NULL) {
        $this->content = "survey/selectForm.php";
        $this->header = "surveyHeader.php";
        $this->extraCSS = "select_form.css";
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
            $param['u'] = $this->user->username;
            $param['selection'] = $this->user->availiblePeriod;
            $this->view($param);
        } else {
            throw new Exception('Illegal parameter provided.');
        }
    }

    function view($param = null) {
        // Overiding method so that appraisee and countersigner will have different default
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
}
