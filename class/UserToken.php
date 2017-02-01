<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminCredential
 *
 * @author user
 */
class UserToken {

    //put your code here
    public $username;
    public $fullName;
    public $department;
    public $position;
    public $commenceDate;
    public $office;
    public $isActive;
    public $accessRight;
    public $isFlaggedForPwReset;
    public $dbConnection;
    public $availiblePeriod = array();
    public $appraiser;
    public $appraiserFullName;
    public $appraisee = array();
    public $countersigner1;
    public $countersignerFullName1;
    public $countersigner2;
    public $countersignerFullName2;
    public $countersignee = array();
    public $countersigneeFullName;
    public $isAdmin;
    public $isReportUser;
    public $activeUid;
    function __construct() {
        $this->dbConnection = new DbConnector();
    }

    function verifyLogin($username, $password) {
        $statement = "SELECT * FROM pa_user WHERE username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':username', $username);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        If (empty($result) || ($result['user_password'] != $password)) {
            return false;
        } else {
            $this->constructUserInfo($username);
            return true;
        }
    }

    function constructUserInfo($username) {         //maybe merge fullname and username with asso array
        $statement = "SELECT * FROM pa_user WHERE username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':username', $username);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        If (!empty($result)) {
            $this->username = $username;
            $this->fullName = $result['user_full_name'];
            $this->department = $result['user_department'];
            $this->position = $result['user_position'];
            $this->office = $result['user_office'];
            $this->commenceDate = $result['commence_date'];
            $this->appraiser = $result['appraiser_username'];
            $this->isSenior = $result['is_senior'];
            $this->isActive = $result['is_active'];
            $this->isAdmin = $result['is_admin'];
            $this->countersigner1 = $result['countersigner_username_1'];
            $this->countersigner2 = $result['countersigner_username_2'];
            $this->isReportUser = $result['is_report_user'];
            $this->isFlaggedForPwReset = $result["is_flagged_for_pw_reset"];
            $userOperator = new UserBatchOperator();
            $right = $userOperator->getUserAccessRight($username);
            $this->accessRight = $right["accessable_user"];
            unset($result);
            $statement = "SELECT user_full_name FROM pa_user WHERE username = :username";
            $query = $this->dbConnection->prepare($statement);
            $query->bindValue(':username', $this->appraiser);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                foreach ($result as $val) {
                    $this->appraiserFullName = $val['user_full_name'];
                }
            }
            
            unset($result);
            $statement = "SELECT username, user_full_name FROM pa_user WHERE (appraiser_username = :username) AND (is_active)";
            $query = $this->dbConnection->prepare($statement);
            $query->bindValue(':username', $this->username);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                foreach ($result as $val) {
                    $this->appraisee[$val['username']] = $val['user_full_name'];
                }
            }

            unset($result);
            $statement = "SELECT * FROM pa_form_period WHERE is_active = True";
            $query = $this->dbConnection->prepare($statement);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                $this->availiblePeriod['uid'] = $result['uid'];
                $this->availiblePeriod['period'] = $result['survey_period'];
                $this->availiblePeriod['type'] = $result['survey_type'];
            } else {
                return false;
            }

            unset($result);
            $statement = "SELECT user_full_name FROM pa_user WHERE username = :username";
            $query = $this->dbConnection->prepare($statement);
            $query->bindValue(':username', $this->countersigner1);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                foreach ($result as $val) {
                    $this->countersignerFullName1 = $val['user_full_name'];
                }
            }

            unset($result);
            $statement = "SELECT user_full_name FROM pa_user WHERE username = :username";
            $query = $this->dbConnection->prepare($statement);
            $query->bindValue(':username', $this->countersigner2);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                foreach ($result as $val) {
                    $this->countersignerFullName2 = $val['user_full_name'];
                }
            }

            unset($result);
            $statement = "SELECT username, user_full_name FROM pa_user WHERE (countersigner_username_1 = :username) AND (is_active)";
            $query = $this->dbConnection->prepare($statement);
            $query->bindValue(':username', $username);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                foreach ($result as $val) {
                    $this->countersignee[$val['username']] = 'counter1';
                    $this->countersigneeFullName[$val['username']] = $val['user_full_name'];
                }
            }
            
            unset($result);
            $statement = "SELECT username, user_full_name FROM pa_user WHERE (countersigner_username_2 = :username) AND (is_active)";
            $query = $this->dbConnection->prepare($statement);
            $query->bindValue(':username', $username);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                foreach ($result as $val) {
                    $this->countersignee[$val['username']] = 'counter2';
                    $this->countersigneeFullName[$val['username']] = $val['user_full_name'];
                }
            }            
            
            unset($result);
            $statement = "SELECT uid FROM pa_form_period WHERE is_active = 1";
            $query = $this->dbConnection->prepare($statement);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                $this->activeUid = 2;
            }
        } else {
            throw new Exception('Cannot construct user token. Maybe username does not exist? Check the query string.');
        }
    }

    function setPassword($pwStr, $pwConfirm) {
        if (!$this->dbConnection) {
            $this->dbConnection = new DbConnector();
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
        $query->bindValue(':username', $this->username);
        $query->execute();
    }
    
    function unflagForReset() {
        if (!$this->dbConnection) {
            $this->dbConnection = new DbConnector();
        }
        $statement = "UPDATE pa_user SET is_flagged_for_pw_reset = 0 WHERE username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':username', $this->username);
        $query->execute();
     }
    
    function getSelfPreviousUid(){
        if (!$this->dbConnection) {
            $this->dbConnection = new DbConnector();
        }
        $statement = "SELECT survey_uid, survey_period, survey_type FROM pa_form_data WHERE form_username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':username', $this->username);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function __sleep() {
        unset($this->dbConnection);
        return array("username", "appraiser", "appraisee", "availiblePeriod", "countersigner1", "countersigner2", "countersignee"
            , "appraiserFullName", "isSenior", "isAdmin", "accessRight", "countersignerFullName1", "countersignerFullName2", "isActive", "isFlaggedForPwReset", "fullName", "position"
            , "office", "commenceDate", "department", "countersigneeFullName", "isReportUser", "activeUid");
    }

}
