<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reportData
 *
 * @author anthony.poon
 */
class reportData {
    //put your code here
    public $uid;
    public $summary;
    
    function __construct() {
        $this->dbConnection = new dbConnector();        
    }
    
    function getSubmittedSurveyIndex($uid) {
        $statement = "SELECT form_username FROM pa_form_data WHERE (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':uid', $uid);
        $query->execute();

        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $index[] = $result['form_username'];
        }
        
        if (!empty($index)){
            return $index;
        } else {
            return $index = array();
        }
    }
    
    function getAvailablePeriod() {
        $statement = "SELECT * FROM pa_form_period";
        $query = $this->dbConnection->prepare($statement);
        $query->execute();
        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $index[$result['uid']]['survey_period'] = $result['survey_period'];
            $index[$result['uid']]['survey_type'] = $result['survey_type'];
            $index[$result['uid']]['is_active'] = $result['is_active'];
        }
        return $index;
    }
    
    function getFormSummary($uid) {
        foreach ($this->getSubmittedSurveyIndex($uid) as $username){
            $form = new formData($username, $uid);
            $this->summary[$username] = $form->getFormData(TRUE);
        }
        return $this->summary;
    }
    
    function getJsonReport(){
        foreach ($this->dataIndex as $username){
            $form = new formData($username, $this->uid);
            $this->result[$username] = $form->getFormData();
        }
        return json_encode($this->result);
    }
    
}
