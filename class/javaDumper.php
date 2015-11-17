<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of javaDumper
 *
 * @author anthony.poon
 */



class javaDumper {
    //put your code here
    private static $hostname = "192.168.0.72";
    private static $port = 32;
    private static $hashId;
    
    static function dump($var, $varName = null) {
        if (self::$hashId === NULL) {
            self::$hashId = uniqid();
        }        
        $returnObj = new stdClass();
        
        $returnObj->timestamp = microtime(TRUE);
        $returnObj->hashedId = self::$hashId;
        $returnObj->content = new stdClass();
        if (is_scalar($var)) {
            $returnObj->content->var = gettype($var)." => ".$var;
        } else {
            $returnObj->content->var = $var;
        }
        $metaDataArray = debug_backtrace();
        if (!empty($metaDataArray[1])){
            $returnObj->functionName = $metaDataArray[1]['function'];
            $returnObj->location = $metaDataArray[0]['file']." : ".$metaDataArray[0]['line'];
            unset($metaDataArray[0]);
            $metaDataObj = new stdClass();        
            foreach ($metaDataArray as $key => $value){
                $metaDataObj->$key = $value;
            }
            $returnObj->metaData = $metaDataObj;
        } else {
            $returnObj->functionName = "GLOBAL SCOPE";
            $returnObj->location = $metaDataArray[0]['file']." : ".$metaDataArray[0]['line'];
            unset($metaDataArray[0]['class']);
            unset($metaDataArray[0]['args']);
            $metaDataArray[0]['function'] = 'GLOBAL SCOPE';
            $metaDataObj = new stdClass();        
            foreach ($metaDataArray as $key => $value){
                $metaDataObj->$key = $value;
            }
            $returnObj->metaData = $metaDataObj;
        }
        if (empty($varName)) {
            $returnObj->varName = $returnObj->location;
        } else {
            $returnObj->varName = $varName;
        }
        
        $connection = @fsockopen(self::$hostname, self::$port, $errorNo, $errorString);
        if (!empty($connection)) {
            fwrite($connection, json_encode($returnObj));
            fclose($connection);
        } else {
            //echo $this->errorNo;
            //echo $this->errorString;
        }
    }
}