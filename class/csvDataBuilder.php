<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of exelDataBuilder
 *
 * @author anthony.poon
 */
class csvDataBuilder {
    //put your code here
    public $dbConnection;
    public $buffer;
    private $header;
    private $uid;
    
    function __construct($uid) {
        $this->dbConnection = new dbConnector();
        $this->uid = $uid;
        $this->header = array();

    }
    function setVisibility($array) {
        $this->header = $array;
    }
    
    function getCSVString() {
        $data = new reportData($this->uid);
        $result = $data->getFormSummary($this->uid);
        if (!empty($this->header)) {
            foreach ($this->header as $columnName) {
                $this->buffer = $this->buffer."\"".$columnName."\",";
            }
            $this->buffer = $this->buffer."\n";
            foreach ($result as $row) {  
                if ($row['is_senior']) {
                    $row['is_senior'] = 'DGM or above';
                } else {
                    $row['is_senior'] = 'Below DGM';
                }
                
                if ($row['is_final_by_self']) {
                    $row['is_final_by_self'] = 'True';
                } else {
                    $row['is_final_by_self'] = 'False';
                }
                
                if ($row['is_final_by_appraiser']) {
                    $row['is_final_by_appraiser'] = 'True';
                } else {
                    $row['is_final_by_appraiser'] = 'False';
                }
                
                foreach ($this->header as $dbName => $friendlyName) {
                    $this->buffer = $this->buffer."\"".$row[$dbName]."\",";
                }
                $this->buffer = $this->buffer."\n";
            }
            return $this->buffer;
        }
    }
}
