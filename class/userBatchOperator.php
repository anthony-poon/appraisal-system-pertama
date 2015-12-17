<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userBatchOperator
 *
 * @author anthony.poon
 */
class userBatchOperator {
    //put your code here
    protected $dbConnector;
    
    function __construct() {
        $this->dbConnector = new dbConnector();
    }
    
    function getUserFullData() {
        $statement = "SELECT * FROM pa_user";
        $query = $this->dbConnector->prepare($statement);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $userData) {
            $data[$userData['username']] = $userData;
        }
        return $data;
    }
    
    function getEmptyUserData() {
        $statement = "SELECT username, user_full_name, is_senior, user_department, "
                . "user_position, user_office, commence_date, appraiser_username, "
                . "countersigner_username_1, countersigner_username_2 "
                . "FROM pa_user WHERE username NOT IN (SELECT form_username FROM pa_form_data) ORDER BY user_office, user_department, user_full_name";
        $query = $this->dbConnector->prepare($statement);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        foreach($result as $userData) {
            $data[$userData['username']]['form_username'] = $userData['username'];
            $data[$userData['username']]['staff_name'] = $userData['user_full_name'];
            $data[$userData['username']]['staff_department'] = $userData['user_department'];
            $data[$userData['username']]['is_senior'] = $userData['is_senior'];
            $data[$userData['username']]['staff_position'] = $userData['user_position'];
            $data[$userData['username']]['staff_office'] = $userData['user_office'];
            $data[$userData['username']]['appraiser_name'] = $this->getFullNameByUsername($userData['appraiser_username']);
            if (!empty($userData['countersigner_username_1']) && !empty($userData['countersigner_username_2'])) {
                $data[$userData['username']]['countersigner_name'] = $this->getFullNameByUsername($userData['countersigner_username_1'])." & ".$this->getFullNameByUsername($userData['countersigner_username_2']);
            } else {
                $data[$userData['username']]['countersigner_name'] = $this->getFullNameByUsername($userData['countersigner_username_1']).$this->getFullNameByUsername($userData['countersigner_username_2']);
            }
            $data[$userData['username']]['survey_commencement_date'] = $userData['commence_date'];
            $data[$userData['username']]['part_a_overall_score'] = null;
            $data[$userData['username']]['part_b1_overall_score'] = null;
            $data[$userData['username']]['part_b2_overall_score'] = null;
            $data[$userData['username']]['part_a_total'] = null;
            $data[$userData['username']]['part_b_total'] = null;
            $data[$userData['username']]['part_a_b_total'] = null;
            $data[$userData['username']]['survey_overall_comment'] = null;
            $data[$userData['username']]['function_training_0_to_1_year'] = null;
            $data[$userData['username']]['function_training_1_to_2_year'] = null;
            $data[$userData['username']]['function_training_2_to_3_year'] = null;
            $data[$userData['username']]['generic_training_0_to_1_year'] = null;
            $data[$userData['username']]['generic_training_1_to_2_year'] = null;
            $data[$userData['username']]['generic_training_2_to_3_year'] = null;            
        }
        return $data;
    }
    
    function getFullNameByUsername($username) {
        $statement = "SELECT user_full_name FROM pa_user WHERE username = :username";
        $query = $this->dbConnector->prepare($statement);
        $query->bindValue(":username", $username);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['user_full_name'];
    }
    
    function adminSetPassword($username, $pwStr, $pwConfirm) {
        if (empty($this->dbConnection)) {
            $this->dbConnection = new dbConnector();
        }
        if (!$pwStr) {
            throw new Exception("Password cannot be empty.");
        } elseif (strcmp($pwStr, $pwConfirm) !== 0) {
            throw new Exception("Mismatched confirmation password.");
        } elseif (strlen($pwStr) <= PASSWORD_MIN_CHAR) {
            throw new Exception("Password too shorts (More than ".PASSWORD_MIN_CHAR." characters)");
        }
        $statement = "UPDATE pa_user SET user_password = :newPw WHERE username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':newPw', $pwStr);
        $query->bindValue(':username', $username);
        $query->execute();
        $errInfo = $this->dbConnection->errorInfo();
        if (!$errInfo) {
            throw new Exception($errInfo[2]);
        }
    }
}
