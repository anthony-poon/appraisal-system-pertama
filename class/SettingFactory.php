<?php

class SettingFactory {
    //put your code here
    public $dbConnection;    
    function __construct() {
        $this->dbConnection = new DbConnector();        
    }
    
    function getSetting($name) {
        $statement = "SELECT value FROM `pa_setting` WHERE name = :name";
        $query = $this->dbConnection->prepare($statement);
        $query->bindValue(":name", $name);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }
}
