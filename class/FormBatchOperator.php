<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormBatchOperator
 *
 * @author anthony.poon
 */
class FormBatchOperator {
    //put your code here
    
    public $dbConnection;
    public $user;
    public $uid;
    
    function __construct($uid){
        $this->dbConnection = new DbConnector();
        $this->uid = $uid;
    }
    
    function lockForm(){
        $statement = "UPDATE pa_form_data SET is_locked = :value WHERE (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':uid', $this->uid);
        $query->bindValue(':value', 1);
        $query->execute();
    }
    
    function unlockForm(){
        $statement = "UPDATE pa_form_data SET is_locked = :value WHERE (survey_uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':uid', $this->uid);
        $query->bindValue(':value', 0);
        $query->execute();
    }
    
    function toggleLock($uid, $u){
        $statement = "UPDATE pa_form_data SET is_locked = (!is_locked) WHERE (survey_uid = :uid) AND (form_username = :form_username)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':uid', $uid);
        $query->bindValue(':form_username', $u);
        $query->execute();
        $error = $query->errorInfo();
        if (empty($error[2])) {
            return false;
        } else {
            return $error;
        }
    }
}
