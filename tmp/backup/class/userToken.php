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
class userToken {

    //put your code here
    public $username;
    public $fullName;
    public $department;
    public $position;
    public $commenceDate;
    public $office;
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

    function __construct() {
        $this->dbConnection = new dbConnector();
    }

    function verifyLogin($username, $password) {
        $statement = "SELECT * FROM pa_user WHERE username = :username";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':username', $username);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        /* If (empty($result) || !password_verify($password,$result['admin_password'])) {
          return false;
          } else {
          $this->adminUsername = $username;
          return true;
          } */
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
            $this->isAdmin = $result['is_admin'];
            $this->countersigner1 = $result['countersigner_username_1'];
            $this->countersigner2 = $result['countersigner_username_2'];
            $this->isReportUser = $result['is_report_user'];

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
            $statement = "SELECT username, user_full_name FROM pa_user WHERE appraiser_username = :username";
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
            $statement = "SELECT username, user_full_name FROM pa_user WHERE (countersigner_username_1 = :username)";
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
            $statement = "SELECT username, user_full_name FROM pa_user WHERE (countersigner_username_2 = :username)";
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
            
        } else {
            throw new Exception('Cannot construct user token. Maybe username does not exist? Check the query string.');
        }
    }

    function __sleep() {
        unset($this->dbConnection);
        return array("username", "appraiser", "appraisee", "availiblePeriod", "countersigner1", "countersigner2", "countersignee"
            , "appraiserFullName", "isSenior", "isAdmin", "countersignerFullName1", "countersignerFullName2", "fullName", "position"
            , "office", "commenceDate", "department", "countersigneeFullName", "isReportUser");
    }

}
