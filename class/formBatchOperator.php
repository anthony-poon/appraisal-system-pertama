<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formBatchOperator
 *
 * @author anthony.poon
 */
class formBatchOperator {
    //put your code here
    
    public $dbConnection;
    public $user;
    public $uid;
    
    function __construct($uid){
        $this->dbConnection = new dbConnector();
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
    
    function deactivateForm() {
        $statement = "UPDATE pa_form_period SET is_active = :value WHERE (uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':uid', $this->uid);
        $query->bindValue(':value', 0);
        $query->execute();
    }
    
    function activateForm() {
        $statement = "UPDATE pa_form_period SET is_active = :value";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':value', 0);
        $query->execute();
        
        $statement = "UPDATE pa_form_period SET is_active = :value WHERE (uid = :uid)";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(':uid', $this->uid);
        $query->bindValue(':value', 1);
        $query->execute();
    }
    
}
