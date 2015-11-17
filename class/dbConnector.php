<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class dbConnector extends PDO{
    function __construct($dbName = DEFAULT_DB) {
        global $dbDriver;
        global $dbHost;
        global $dbUser;
        global $dbPassword;
        try {
            $dsn = $dbDriver.":host=".$dbHost.';dbname='.$dbName;
            parent::__construct($dsn, $dbUser, $dbPassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('db_statement', array($this)));
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
    
    function prepare($statement, $driver_options = array()) {
        if (DEVELOPMENT_ENVIRONMENT) {
            $dumpStr = "\n";
            $backTrace = debug_backtrace();
            $timeStamp = date('m/d/Y h:i:s a', time());
            if ($backTrace[1]['function'] === 'updateData') {
                $dumpStr .= "[Calling Function: ".$backTrace[1]['function']."]";
                if (!empty($_SESSION['user'])) {
                    $userObj = unserialize($_SESSION['user']);
                    $dumpStr .= " [Session user: ".$userObj->username."] [".$timeStamp."]\n";
                }
                $dumpStr .= $statement."\n";
                $dumpStr .= "Call Stack: ";
                for ($i = 0; $i < count($backTrace); $i++) {
                    $dumpStr .= $backTrace[$i]['function'];
                    if ($i < count($backTrace)-1) {
                        $dumpStr .= " => "; // Add comma for all elements instead of last
                    } else {
                        $dumpStr .= "\n";
                    }
                }

                file_put_contents(TEMP.DS."logs".DS."mysql.log",$dumpStr, FILE_APPEND);
            }
        }
        return parent::prepare($statement, $driver_options);
    }
}

class db_statement extends PDOStatement 
{
    protected $pdo;

    protected function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    
    function bindParam($parameter, &$variable, $data_type = PDO::PARAM_STR, $length = null, $driver_options = null) {
        if (DEVELOPMENT_ENVIRONMENT) {
            $backTrace = debug_backtrace();
            if ($backTrace[1]['function'] === 'updateData') {
                if ($variable === null) {
                    $str = 'NULL';
                } else if ($variable === "0") {
                    $str = "\"0\"";
                } else if ($variable === 0){
                    $str = "0";
                } else if ($variable === TRUE) {
                    $str = "TRUE";
                } else if ($variable === FALSE) {
                    $str = "FALSE";
                } else {
                    $str = $variable;
                }
                $dumpStr = "bindParam: ".$parameter." => ".$str."\n";
                file_put_contents(TEMP.DS."logs".DS."mysql.log",$dumpStr, FILE_APPEND);
            }
        }
        parent::bindParam($parameter, $variable, $data_type, $length, $driver_options);
    }
    
    function bindValue($parameter, $value, $data_type = PDO::PARAM_STR) {
        if (DEVELOPMENT_ENVIRONMENT) {
            $backTrace = debug_backtrace();
            if ($backTrace[1]['function'] === 'updateData') {
                if ($value === null) {
                    $str = 'NULL';
                } else if ($value === "0") {
                    $str = "\"0\"";
                } else if ($value === 0){
                    $str = "0";
                } else if ($value === TRUE) {
                    $str = "TRUE";
                } else if ($value === FALSE) {
                    $str = "FALSE";
                } else {
                    $str = $value;
                }
                $dumpStr = "bindValue: ".$parameter." => ".$str."\n";
                file_put_contents(TEMP.DS."logs".DS."mysql.log",$dumpStr, FILE_APPEND);
            }
        }
        parent::bindValue($parameter, $value, $data_type);
    }
}

