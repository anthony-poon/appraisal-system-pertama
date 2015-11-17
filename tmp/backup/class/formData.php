<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formData
 *
 * @author anthony.poon
 */
class formData {

    //put your code here
    public $dbConnection;
    public $username;
    public $user;
    public $uid;

    function __construct($username, $uid) {
        $this->dbConnection = new dbConnector();    //need to check for access right to see if usertoken have access to the formData of provided username; throw exception if not. Maybe concider creating read-only access later
        $this->uid = $uid;
        $this->username = $username;
    }

    function isNewForm() {
        $this->user = new userToken();
        $this->user->constructUserInfo($this->username);
        $statement = "SELECT form_username FROM pa_form_data WHERE (form_username = :username) AND (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':username', $this->user->username);
        $query->bindParam(':uid', $this->uid);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if (empty($result)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function renderNewForm() {
        $statement = "INSERT INTO pa_form_data "
                    . "(form_username, survey_uid, staff_name, is_senior, staff_department, staff_position, "
                    . "staff_office, survey_commencement_date, appraiser_name, countersigner_name, survey_period, survey_type, countersigner_1_name, "
                    . "countersigner_2_name, countersigner_1_weight, countersigner_2_weight) "
                    . "VALUES (:username, :uid, :fullName, :isSenior, :department, :position, :office, :commenceDate, :appraiserFullName, :bothCounter, :survey_period, :survey_type, :counter1, :counter2, :weight1, :weight2)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':username', $this->user->username);
        $query->bindValue(':uid', $this->uid);
        $query->bindValue(':fullName', $this->user->fullName);
        $query->bindValue(':isSenior', $this->user->isSenior);
        $query->bindValue(':department', $this->user->department);
        $query->bindValue(':position', $this->user->position);
        $query->bindValue(':office', $this->user->office);
        $query->bindValue(':commenceDate', $this->user->commenceDate);
        $query->bindValue(':appraiserFullName', $this->user->appraiserFullName);
        $query->bindValue(':counter1', $this->user->countersignerFullName1);
        $query->bindValue(':counter2', $this->user->countersignerFullName2);
        if (!empty($this->user->countersignerFullName1) && !empty($this->user->countersignerFullName2)) {
            $query->bindValue(':weight1', 50);
            $query->bindValue(':weight2', 50);
        } else if (empty($this->user->countersignerFullName1) && !empty($this->user->countersignerFullName2)) {
            $query->bindValue(':weight1', NULL);
            $query->bindValue(':weight2', 100);
        } else if (!empty($this->user->countersignerFullName1) && empty($this->user->countersignerFullName2)) {
            $query->bindValue(':weight1', 100);
            $query->bindValue(':weight2', NULL);
        }
        if (!empty($this->user->countersignerFullName1) && !empty($this->user->countersignerFullName2)) {
            $jointString = $this->user->countersignerFullName1 . " & " . $this->user->countersignerFullName2;
        } else {
            $jointString = $this->user->countersignerFullName1 . $this->user->countersignerFullName2;
        }
        $query->bindValue(':bothCounter', $jointString);
        $query->bindValue(':survey_period', $this->user->availiblePeriod['period']);        				//Need to throw an Exception here later if there is not active survey
        $query->bindValue(':survey_type', $this->user->availiblePeriod['type']);
        $query->execute();

        $statement = "INSERT IGNORE INTO pa_part_a SET form_username = :username, survey_uid = :uid, question_no = :no";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':username', $this->user->username);
        $query->bindValue(':uid', $this->uid);
        $query->bindParam(':no', $i);
        for ($i = 1; $i <= 3; $i++){
            $query->execute();
        }
    }
    
    function getFormData($summaryOnly = false) {
        $statement = "SELECT * FROM pa_form_data WHERE (form_username = :username) AND (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':username', $this->username);
        $query->bindParam(':uid', $this->uid);
        $query->execute();
        $formResult = $query->fetch(PDO::FETCH_ASSOC);
        if (!empty($formResult) && $summaryOnly == false) {
            $statement = "SELECT * FROM pa_part_a WHERE (form_username = :username) AND (survey_uid = :uid)";
            $query = $this->dbConnection->prepare($statement);
            $query->bindParam(':username', $this->username);
            $query->bindParam(':uid', $this->uid);
            $query->execute();
            $formResult['partA'] = $query->fetchAll(PDO::FETCH_ASSOC);

            $statement = "SELECT * FROM pa_part_b1 WHERE (form_username = :username) AND (survey_uid = :uid)";
            $query = $this->dbConnection->prepare($statement);
            $query->bindParam(':username', $this->username);
            $query->bindParam(':uid', $this->uid);
            $query->execute();
            $formResult['partB1'] = $query->fetchAll(PDO::FETCH_ASSOC);

            $statement = "SELECT * FROM pa_part_b2 WHERE (form_username = :username) AND (survey_uid = :uid)";
            $query = $this->dbConnection->prepare($statement);
            $query->bindParam(':username', $this->username);
            $query->bindParam(':uid', $this->uid);
            $query->execute();
            $formResult['partB2'] = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $statement = "SELECT * FROM pa_part_d WHERE (form_username = :username) AND (survey_uid = :uid)";
            $query = $this->dbConnection->prepare($statement);
            $query->bindParam(':username', $this->username);
            $query->bindParam(':uid', $this->uid);
            $query->execute();
            $formResult['partD'] = $query->fetchAll(PDO::FETCH_ASSOC);

            return $formResult;
        } else if (!empty($formResult) && $summaryOnly == true){
            $statement = "SELECT * FROM pa_part_d WHERE (form_username = :username) AND (survey_uid = :uid)";
            $query = $this->dbConnection->prepare($statement);
            $query->bindParam(':username', $this->username);
            $query->bindParam(':uid', $this->uid);
            $query->execute();
            $formResult['partD'] = $query->fetchAll(PDO::FETCH_ASSOC);
            
            return $formResult;
        } else {
            return false;
        }
    }
       
    function getPartACount() {
        $statement = "SELECT MAX(question_no) FROM pa_part_a WHERE (form_username = :username) AND (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':username', $this->username);
        $query->bindParam(':uid', $this->uid);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['MAX(question_no)'];
    }
    
    function getPartDCount() {
        $statement = "SELECT MAX(question_no) FROM pa_part_d WHERE (form_username = :username) AND (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':username', $this->username);
        $query->bindParam(':uid', $this->uid);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['MAX(question_no)'];
    }
    
    function updateData($fieldName, $value) {
        // $columnName need to be filtered in future patch 
        if ($fieldName != 'is_locked' && ($value === '0' || $value === '')) {
            $value = null;
        }

        //$value = htmlspecialchars($value, ENT_QUOTES);
        
        if ((substr($fieldName, 0, 7)) == 'multi_a') {
            $str = explode('_', $fieldName);
            $qid = $str[count($str) - 1];
            $columnName = $str[2] . "_" . $str[3];

            $statement = "INSERT INTO pa_part_a SET `question_no` = :qid , `form_username` = :username , `survey_uid` = :uid, `$columnName` = :value ON DUPLICATE KEY UPDATE `$columnName` = :value";
            $query = $this->dbConnection->prepare($statement);
            $query->bindValue(':username', $this->username);
            $query->bindValue(':uid', $this->uid);
            $query->bindValue(':qid', $qid);
            $query->bindValue(':value', $value);
            $query->execute();
        } else if ((substr($fieldName, 0, 8)) == 'multi_b1') {
            $str = explode('_', $fieldName);
            $qid = $str[count($str) - 1];
            $columnName = $str[2] . "_" . $str[3];
            $statement = "INSERT INTO pa_part_b1 SET `question_no` = :qid , `form_username` = :username , `survey_uid` = :uid, `$columnName` = :value ON DUPLICATE KEY UPDATE `$columnName` = :value";
            $query = $this->dbConnection->prepare($statement);
            $query->bindValue(':username', $this->username);
            $query->bindValue(':uid', $this->uid);
            $query->bindValue(':qid', $qid);
            $query->bindValue(':value', $value);
            $query->execute();
        } else if ((substr($fieldName, 0, 8)) == 'multi_b2') {
            $str = explode('_', $fieldName);
            $qid = $str[count($str) - 1];
            $columnName = $str[2] . "_" . $str[3];
            $statement = "INSERT INTO pa_part_b2 SET `question_no` = :qid , `survey_uid` = :uid, `form_username` = :username , `$columnName` = :value ON DUPLICATE KEY UPDATE `$columnName` = :value";
            $query = $this->dbConnection->prepare($statement);
            $query->bindValue(':username', $this->username);
            $query->bindValue(':uid', $this->uid);
            $query->bindValue(':qid', $qid);
            $query->bindValue(':value', $value);
            $query->execute();
        } else if ((substr($fieldName, 0, 7)) == 'multi_d') {
            $str = explode('_', $fieldName);
            $qid = $str[count($str) - 1];
            $columnName = $str[2] . "_" . $str[3];
            $statement = "INSERT INTO pa_part_d SET `question_no` = :qid , `survey_uid` = :uid, `form_username` = :username , `$columnName` = :value ON DUPLICATE KEY UPDATE `$columnName` = :value";
            $query = $this->dbConnection->prepare($statement);
            $query->bindValue(':username', $this->username);
            $query->bindValue(':uid', $this->uid);
            $query->bindValue(':qid', $qid);
            $query->bindValue(':value', $value);
            $query->execute();
        } else {
            $statement = "UPDATE pa_form_data SET $fieldName = :value WHERE (form_username = :username) AND (survey_uid = :uid)";
            $query = $this->dbConnection->prepare($statement);
            $query->bindParam(':username', $this->username);
            $query->bindValue(':uid', $this->uid);
            $query->bindValue(':value', $value);
            $query->execute();
        }
    }
    
    function clearPartAEntry($questionNo) {
        $rowCount = $this->getPartACount();     //need to check if the record existed or not before deleting, need to return result
        $statement = "DELETE FROM pa_part_a WHERE (form_username = :username) AND (survey_uid = :uid) AND (question_no = :no)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':username', $this->username);
        $query->bindValue(':uid', $this->uid);
        $query->bindParam(':no', $questionNo);
        $query->execute();
        
        $statement = "UPDATE pa_part_a SET question_no = (:no - 1) WHERE (form_username = :username) AND (survey_uid = :uid) AND (question_no = :no)";
        $query = $this->dbConnection->prepare($statement);        
        $query->bindValue(':username', $this->username);
        $query->bindValue(':uid', $this->uid);
        for ($i = $questionNo + 1; $i <= $rowCount; $i++) {
            $query->bindParam(':no', $i);
            $query->execute();
        }
    }
    
    function clearPartDEntry($questionNo) {
        $rowCount = $this->getPartDCount();     //need to check if the record existed or not before deleting, need to return result
        $statement = "DELETE FROM pa_part_d WHERE (form_username = :username) AND (survey_uid = :uid) AND (question_no = :no)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindParam(':username', $this->username);
        $query->bindValue(':uid', $this->uid);
        $query->bindParam(':no', $questionNo);
        $query->execute();
        
        $statement = "UPDATE pa_part_d SET question_no = (:no - 1) WHERE (form_username = :username) AND (survey_uid = :uid) AND (question_no = :no)";
        $query = $this->dbConnection->prepare($statement);        
        $query->bindValue(':username', $this->username);
        $query->bindValue(':uid', $this->uid);
        for ($i = $questionNo + 1; $i <= $rowCount; $i++) {
            $query->bindParam(':no', $i);
            $query->execute();
        }
    }
}
