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
    
    function addUser(User $user, $password) {
        $statement = "INSERT INTO pa_user SET user_full_name = :fullName, username = :username, user_password = :pw";
        $query = $this->dbConnector->prepare($statement);
        $query->bindValue(":fullName", $user->getStaffName());
        $query->bindValue(":username", $user->getUsername());
        $query->bindValue(":pw", $password);
        $query->execute();
        return $this->dbConnector->lastInsertId();
    }
    
    function createUserObj($userId = null, $showHidden = false) {
        $statement = "SELECT user.*, ao.user_full_name as appraiser_name, "
                . "co1.user_full_name as countersigner_1_name, "
                . "co2.user_full_name as countersigner_2_name "
                . "FROM pa_user as user "
                . "LEFT JOIN pa_user as ao "
                . "ON user.appraiser_username = ao.username "
                . "LEFT JOIN pa_user as co1 "
                . "ON user.countersigner_username_1 = co1.username "
                . "LEFT JOIN pa_user as co2 "
                . "ON user.countersigner_username_2 = co2.username";
        if (empty($userId)) {
            if (!$showHidden) {
                $statement = $statement." WHERE user.`is_active`";
            }
            $query = $this->dbConnector->prepare($statement);
            $query->execute();
            $returnArray = array();
            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                $returnArray[] = new User($result);
            }
            return $returnArray;
        } else if (!is_array($userId)){
            $statement = $statement." WHERE user.`user_id` = :uid";
            $query = $this->dbConnector->prepare($statement);
            $query->bindValue(":uid",$userId);
            $query->execute();
            return new User($query->fetch(PDO::FETCH_ASSOC));            
        }
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
    
    public function getParticipatedPeriod($username) {
        if (empty($this->dbConnection)) {
            $this->dbConnection = new DbConnector();
        }
        $statement = "SELECT survey_uid, survey_period FROM `pa_form_data` WHERE form_username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(":username", $username);
        $query->execute();
        $returnArray = array();
        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $returnArray[$result["survey_uid"]] = $result["survey_period"];
        }
        return $returnArray;
    }

    public function updateUser($user) {
        /* @var $user User */
        if (empty($this->dbConnection)) {
            $this->dbConnection = new DbConnector();
        }
        $statement = "UPDATE pa_user set "
                . "user_full_name = :user_full_name, "
                . "user_email = :user_email, "
                . "is_senior = :is_senior, "
                . "is_admin = :is_admin, "
                . "is_report_user = :is_report_user, "
                . "user_department = :user_department, "
                . "user_position = :user_position, "
                . "user_office = :user_office, "
                . "commence_date = :commence_date, "
                . "appraiser_username = :appraiser_username, "
                . "countersigner_username_1 = :countersigner_username_1, "
                . "countersigner_username_2 = :countersigner_username_2, "
                . "is_active = :is_active, "
                . "is_hidden = :is_hidden "
                . "WHERE user_id = :uid";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(":uid", $user->getUserID());
        $query->bindValue(":user_full_name", $user->getStaffName());
        $query->bindValue(":user_email", $user->getEmail());
        $query->bindValue(":is_senior", $user->getIsSenior());
        $query->bindValue(":is_admin", $user->getIsAdmin());
        $query->bindValue(":is_report_user", $user->getIsReportUser());
        $query->bindValue(":user_department", $user->getDepartment());
        $query->bindValue(":user_position", $user->getPosition());
        $query->bindValue(":user_office", $user->getOffice());
        if ($user->getCommenceDate() === null) {
            $query->bindValue(":commence_date", NULL);
        } else {
            $query->bindValue(":commence_date", $user->getCommenceDateStr());
        }
        
        $query->bindValue(":appraiser_username", $user->getAoUsername());
        $query->bindValue(":countersigner_username_1", $user->getCo1Username());
        $query->bindValue(":countersigner_username_2", $user->getCo2Username());
        $query->bindValue(":is_active", $user->getIsActive());
        $query->bindValue(":is_hidden", $user->getIsHidden());
        $query->execute();
        
        // regrab the object and update current form
        $user = $this->createUserObj($user->getUserID());
        $statement = "UPDATE `pa_form_data` SET staff_name = :staff_name, "
                . "is_senior = :is_senior, "
                . "staff_department = :department, "
                . "staff_position = :position, "
                . "staff_office = :office, "
                . "appraiser_name = :ao_name, "
                . "countersigner_name = :co_combined, "
                . "countersigner_1_name = :co1_name, "
                . "countersigner_2_name = :co2_name, "
                . "survey_commencement_date = :commence_date "
                . "WHERE survey_uid = (SELECT MAX(uid) FROM pa_form_period WHERE is_active) "
                . "AND form_username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(":staff_name", $user->getStaffName());
        $query->bindValue(":is_senior", $user->getIsSenior());
        $query->bindValue(":department", $user->getDepartment());
        $query->bindValue(":position", $user->getPosition());
        $query->bindValue(":office", $user->getOffice());
        $query->bindValue(":ao_name", $user->getAoName());
        $str = $user->getCo1Name();
        if (!empty($user->getCo2Name())) {
            $str = $str." & ".$user->getCo2Name();
        }
        $query->bindValue(":co_combined", $str);
        $query->bindValue(":co1_name", $user->getCo1Name());
        $query->bindValue(":co2_name", $user->getCo2Name());
        
        if ($user->getCommenceDate() === null) {
            $query->bindValue(":commence_date", NULL);
        } else {
            $query->bindValue(":commence_date", $user->getCommenceDateStr());
        }
        $query->bindValue(":username", $user->getUsername());
        $query->execute();
        
    }
}
