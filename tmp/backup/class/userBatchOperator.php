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
}
