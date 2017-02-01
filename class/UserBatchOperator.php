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
class UserBatchOperator {
    //put your code here
    protected $dbConnector;
    
    function __construct() {
        $this->dbConnector = new DbConnector();
    }
    
    function getUserAccessRight($username){
        $statement = "SELECT username, is_senior, is_admin, is_report_user, user_department FROM pa_user WHERE username = :username";
        $query = $this->dbConnector->prepare($statement);
        $query->bindValue(":username",$username);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user["is_admin"]) {
            // If is it admin, read all
            $statement = "SELECT username from pa_user";
            $query = $this->dbConnector->prepare($statement);
            $query->execute();
            $user["accessable_user"] = $query->fetchAll(PDO::FETCH_COLUMN);
        } else {
            // First get all report that he is able to countersign/appraise first (Not historical)
            $statement = "SELECT username from pa_user WHERE (appraiser_username = :username) OR (countersigner_username_1 = :username) OR (countersigner_username_2 = :username)";
            $query = $this->dbConnector->prepare($statement);
            $query->bindValue(":username",$username);
            $query->execute();
            $user["accessable_user"] = $query->fetchAll(PDO::FETCH_COLUMN);
            // Then get all report under his department
            if ($user["is_senior"] && $user["is_report_user"]) {
                $statement = "SELECT username from pa_user WHERE user_department = :department";
                $query->bindValue(":department", $user["user_department"]);
                $query->execute();
                foreach ($query->fetchAll(PDO::FETCH_COLUMN) as $accessableUser) {
                    if (!in_array($accessableUser, $user["accessable_user"])) {
                        array_push($user["accessable_user"], $accessableUser);
                    }
                }
            }
            if (!in_array($username, $user["accessable_user"])) {
                array_push($user["accessable_user"], $username);
            }
        }
        return $user;
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
    
    function getUsername(){
        $statement = "SELECT username FROM pa_user";
        $query = $this->dbConnector->prepare($statement);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
    
    function getEmptyUserData($uid) {
        $statement = "SELECT username, user_full_name, is_senior, user_department, "
                . "user_position, user_office, commence_date, appraiser_username, "
                . "countersigner_username_1, countersigner_username_2 "
                . "FROM pa_user WHERE (username NOT IN (SELECT form_username FROM pa_form_data WHERE survey_uid = :uid) AND is_active)";
        $query = $this->dbConnector->prepare($statement);
        $query->bindValue(":uid", $uid);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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
            $this->dbConnection = new DbConnector();
        }
        if ($pwStr === "") {
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
    
    function toggleStatus($username) {
        if (empty($this->dbConnection)) {
            $this->dbConnection = new DbConnector();
        }
        $statement = "UPDATE pa_user SET is_active = !is_active WHERE username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':username', $username);
        $query->execute();        
    }
    
    function getFileCategory(){
        if (empty($this->dbConnection)) {
            $this->dbConnection = new DbConnector();
        }
        $statement = "SELECT category_name from pa_file_category WHERE is_active";
        $query = $this->dbConnection->prepare($statement);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
    
    function getEmailByUsername($username){
        if (empty($this->dbConnection)) {
            $this->dbConnection = new DbConnector();
        }
        $statement = "SELECT user_email from pa_user WHERE username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(":username", $username);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_COLUMN);
        return $result;
    }
    
    function setEmailByUsername($username, $email) {
        if (empty($this->dbConnection)) {
            $this->dbConnection = new DbConnector();
        }
        $statement = "UPDATE pa_user set user_email = :user_email WHERE username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(":user_email", $email);
        $query->bindValue(":username", $username);
        $query->execute();
        $errInfo = $this->dbConnection->errorInfo();
        if (!$errInfo) {
            throw new Exception($errInfo[2]);
        }
    }
}
