<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportScoreData
 *
 * @author anthony.poon
 */
class ReportScoreData {
    //put your code here
    private $username = array();
    private $staffName = array();
    private $periodName = array();
    private $dataMap = array();
    
    public function addEntry($username, $staffName, $periodName, $partAScore, $partBScore, $totalScore) {
        if (!in_array($username, $this->username)) {
            $this->username[] = $username;
            $this->staffName[$username] = $staffName;
        }
        if (!in_array($periodName, $this->periodName)) {
            $this->periodName[] = $periodName;
        }
        $this->dataMap[$username][$periodName]["part_a"] = $partAScore;
        $this->dataMap[$username][$periodName]["part_b"] = $partBScore;
        $this->dataMap[$username][$periodName]["total"] = $totalScore;
    }
    
    public function getPartA($username, $periodName) {
        if (isset($this->dataMap[$username][$periodName]["part_a"])) {
            return $this->dataMap[$username][$periodName]["part_a"];
        } else {
            return null;
        }
    }
    
    public function getPartB($username, $periodName) {
        if (isset($this->dataMap[$username][$periodName]["part_b"])) {
            return $this->dataMap[$username][$periodName]["part_b"];
        } else {
            return null;
        }
    }
    
    public function getTotal($username, $periodName) {
        if (isset($this->dataMap[$username][$periodName]["total"])) {
            return $this->dataMap[$username][$periodName]["total"];
        } else {
            return null;
        }
    }
    
    public function getStaffName($username) {
        if (isset($this->staffName[$username])) {
            return $this->staffName[$username];
        } else {
            return null;
        }
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getPeriodName() {
        return $this->periodName;
    }
}
