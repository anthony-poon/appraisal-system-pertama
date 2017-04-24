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
                . "AND NOT user.is_hidden "
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
        
        $statement = "SELECT form_username, survey_uid, staff_name, form.is_senior, "
                . "staff_position, staff_department, staff_office, appraiser_name, countersigner_name, countersigner_1_name, "
                . "countersigner_2_name, survey_period, survey_type, part_a_total, "
                . "part_b_total, part_a_b_total, is_final_by_self, is_final_by_appraiser, is_final_by_counter1, is_final_by_counter2, is_locked "
                . "FROM pa_form_data as form "
                . "LEFT JOIN pa_user as user ON "
                . "form.form_username = user.username "
                . "WHERE NOT user.is_hidden AND (survey_uid = :uid)";
        if (!empty($usernameArray)) {
            foreach ($usernameArray as $name) {
                if (!preg_match("/^([0-9a-zA-Z\.,])+$/", $name)) {
					var_dump($name);
                    throw new Exception("Illegal query string");
                }
                $temp[] = "\"".$name."\"";
            }
            $str = implode(",", $temp);
            $statement = $statement. " AND (form_username in ($str))";
        }
        $statement = $statement. " ORDER BY staff_office, staff_department, is_senior DESC";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':uid', $uid);
      
        $query->execute();
        $resultArray = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultArray as $result) {
            $returnArray[$result["form_username"]] = new ReportSummaryData($result);
        }
        return $returnArray;
    }
    
    function getFormDetail($uid) {
        // No defailt for wach part yet
        $returnArray = array();
        
        $statement = "SELECT * "
                . "FROM pa_form_data as form "
                . "LEFT JOIN pa_user as user ON "
                . "form.form_username = user.username "
                . "WHERE NOT user.is_hidden AND (survey_uid = :uid)";
        if (!empty($usernameArray)) {
            foreach ($usernameArray as $name) {
                if (!preg_match("/^([0-9a-zA-Z\.,])+$/", $name)) {
                    throw new Exception("Illegal query string");
                }
                $temp[] = "\"".$name."\"";
            }
            $str = implode(",", $temp);
            $statement = $statement. " AND (form_username in ($str))";
        }
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':uid', $uid);
      
        $query->execute();
        $queryResult = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($queryResult as $query) {
            $returnArray[$query["form_username"]] = $query;
        }
        return $returnArray;
    }
    
    function getPartAData($uid) {
        $statement = "SELECT * "
                . "FROM pa_part_a as form "
                . "LEFT JOIN oa_user as user ON "
                . "form.form_username = user.username "
                . "WHERE (survey_uid = :uid)";
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
        $statement = "SELECT * "
                . "FROM pa_part_b1 as form "
                . "LEFT JOIN oa_user as user ON "
                . "form.form_username = user.username "
                . "WHERE (survey_uid = :uid)";
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
        $statement = "SELECT * "
                . "FROM pa_part_b2 as form "
                . "LEFT JOIN oa_user as user ON "
                . "form.form_username = user.username "
                . "WHERE (survey_uid = :uid)";
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
        $statement = "SELECT * "
                . "FROM pa_part_d as form "
                . "LEFT JOIN pa_user as user ON "
                . "form.form_username = user.username "
                . "WHERE (survey_uid = :uid)";
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
