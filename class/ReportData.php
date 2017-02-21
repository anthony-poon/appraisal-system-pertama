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
class ReportData {
    //put your code here
    public $uid;
    public $summary;
    public $dbConnection;
    const ORDER_BY_FINAL_SCORE = 1;
    
    function __construct() {
        $this->dbConnection = new DbConnector();        
    }
    
    function getScoreReport() {
        $statement = "SELECT form.form_username, user.is_active, form.survey_uid, period.survey_period, form.staff_name, part_a_total"
                . ", part_b_total, part_a_b_total "
                . "FROM pa_form_data as form "
                . "LEFT JOIN pa_form_period as period ON "
                . "form.survey_uid = period.uid "
                . "LEFT JOIN pa_user as user ON "
                . "form.form_username = user.username "
                . "WHERE user.is_active "
                . "AND form.survey_uid IN (SELECT * FROM ("
                . "SELECT uid from pa_form_period "
                . "ORDER BY uid DESC "
                . "LIMIT 10) as sub1)";
        $query = $this->dbConnection->prepare($statement);
        $query->execute();
        $returnArray = array();
        $data = new ReportScoreData();
        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $data->addEntry($result["form_username"], $result["staff_name"], $result["survey_period"], $result["part_a_total"], $result["part_b_total"], $result["part_a_b_total"]);
        }
        return $data;
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
    
    function getFormSummary($uid, $usernameArray = null) {
		$returnArray = array();
        if (empty($usernameArray)) {
            $statement = "SELECT form_username, survey_uid, staff_name, is_senior, "
                    . "staff_position, staff_department, staff_office, appraiser_name, countersigner_name, countersigner_1_name, "
                    . "countersigner_2_name, survey_commencement_date, survey_period, survey_type, function_training_0_to_1_year, "
                    . "function_training_1_to_2_year, function_training_2_to_3_year, generic_training_0_to_1_year, generic_training_1_to_2_year, "
                    . "generic_training_2_to_3_year, survey_overall_comment, part_a_overall_score, part_a_total, countersigner_1_part_a_score, countersigner_2_part_a_score,"
                    . "part_b1_overall_score, part_b2_overall_score, countersigner_1_part_b_score, countersigner_2_part_b_score,"
                    . "part_b_total, part_a_b_total, is_final_by_self, is_final_by_appraiser, is_final_by_counter1, is_final_by_counter2, is_locked FROM pa_form_data WHERE (survey_uid = :uid)";
            $query = $this->dbConnection->prepare($statement);
            $query->bindParam(':uid', $uid);
        } else {
            foreach ($usernameArray as $name) {
                if (!preg_match("/^([0-9a-zA-Z\.,])+$/", $name)) {
                    throw new Exception("Illegal query string");
                }
                $temp[] = "\"".$name."\"";
            }
            $str = implode(",", $temp);
            $statement = "SELECT * FROM pa_form_data WHERE (survey_uid = :uid) AND (form_username in ($str))";
            $query = $this->dbConnection->prepare($statement);
            $query->bindParam(':uid', $uid);

        }        
        $query->execute();
        $queryResult = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($queryResult as $query) {
            $returnArray[$query["form_username"]] = $query;
        }
        return $returnArray;
    }
    
    function getPartAData($uid) {
        $statement = "SELECT * FROM pa_part_a WHERE (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':uid', $uid);
        $query->execute();
        $queryResult = $query->fetchAll(PDO::FETCH_ASSOC);
		$returnArray = array();
        foreach ($queryResult as $query) {
            $returnArray[$query["form_username"]][] = $query;
        }
        return $returnArray;
    }
    
    function getPartB1Data($uid) {
        $statement = "SELECT * FROM pa_part_b1 WHERE (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':uid', $uid);
        $query->execute();
        $queryResult = $query->fetchAll(PDO::FETCH_ASSOC);
        $returnArray = array();
        foreach ($queryResult as $query) {
            $returnArray[$query["form_username"]][] = $query;
        }
        return $returnArray;
    }
    
    function getPartB2Data($uid) {
        $statement = "SELECT * FROM pa_part_b2 WHERE (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':uid', $uid);
        $query->execute();
        $queryResult = $query->fetchAll(PDO::FETCH_ASSOC);
        $returnArray = array();
        foreach ($queryResult as $query) {
            $returnArray[$query["form_username"]][] = $query;
        }
        return $returnArray;
    }
    
    function getGoalData($uid) {
        $statement = "SELECT * FROM pa_part_d WHERE (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':uid', $uid);
        $query->execute();
        $queryResult = $query->fetchAll(PDO::FETCH_ASSOC);
        $returnArray = array();
        foreach ($queryResult as $field) {
            $returnArray[$field['form_username']][$field['question_no']] = $field;
        }		
        return $returnArray;
    }
    
}
