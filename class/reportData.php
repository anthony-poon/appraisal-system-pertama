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
    public $dbConnection;
    const ORDER_BY_FINAL_SCORE = 1;
    
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
    
    function getFormSummary($uid, $orderStle = 0) {
        $statement = "SELECT * FROM pa_form_data WHERE (survey_uid = :uid)";
        switch ($orderStle) {
            case 0;
                $statement = $statement."ORDER BY staff_office,staff_department, staff_name";
                break;
            case 1;
                $statement = $statement."ORDER BY part_a_b_total DESC, staff_office, staff_department, staff_name";
                break;
        }
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':uid', $uid);
        $query->execute();
        $queryResult = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($queryResult as $field) {
            $returnArray[$field['form_username']] = $field;
        }
        return $returnArray;
    }
    
    function getGoalData($uid) {
        $statement = "SELECT * FROM pa_part_d WHERE (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':uid', $uid);
        $query->execute();
        $queryResult = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($queryResult as $field) {
            $returnArray[$field['form_username']][$field['question_no']] = $field;
        }
        return $returnArray;
    }
    
    function getJsonReport(){
        foreach ($this->getSubmittedSurveyIndex($this->uid) as $username){
            $form = new formData($username, $this->uid);
            $this->result[$username] = $form->getFormData();
        }
        return json_encode($this->result);
    }
    
}
