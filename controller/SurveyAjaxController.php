<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SurveyAjax
 *
 * @author anthony.poon
 */
class SurveyAjaxController extends PrivilegedZone {
    //put your code here
    
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
