<?php

class ReportSummaryData {
    //put your code here
    private $staffName;
    private $office;
    private $department;
    private $position;
    private $username;
    private $seniority;
    private $aoName;
    private $co1Name;
    private $co2Name;
    private $partAScore;
    private $partBScore;
    private $totalScore;
    private $selfStatus;
    private $aoStatus;
    private $co1Status;
    private $co2Status;
    private $lockStatus;
    
    public function __construct($result) {
        foreach ($result as $key => $value) {
            switch ($key) {
                case "staff_name":
                    $this->staffName = $value;
                    break;
                case "staff_office":
                    $this->office = $value;
                    break;
                case "staff_department":
                    $this->department = $value;
                    break;
                case "staff_position":
                    $this->position = $value;
                    break;
                case "form_username":
                    $this->username = $value;
                    break;
                case "is_senior":
                    $this->seniority = ($value === "1");
                    break;
                case "appraiser_name":
                    $this->aoName = $value;
                    break;
                case "countersigner_1_name":
                    $this->co1Name = $value;
                    break;
                case "countersigner_2_name":
                    $this->co2Name = $value;
                    break;
                case "part_a_total":
                    $this->partAScore = $value;
                    break;
                case "part_b_total":
                    $this->partBScore = $value;
                    break;
                case "part_a_b_total":
                    $this->totalScore = $value;
                    break;
                case "is_final_by_self":
                    $this->selfStatus = $value;
                    break;
                case "is_final_by_appraiser":
                    $this->aoStatus = $value;
                    break;
                case "is_final_by_counter1":
                    $this->co1Status = $value;
                    break;
                case "is_final_by_counter1":
                    $this->co2Status = $value;
                    break;
                case "is_locked":
                    $this->lockStatus = $value;
                    break;
            }
        }
    }
    
    function getStaffName() {
        return $this->staffName;
    }

    function setStaffName($staffName) {
        $this->staffName = $staffName;
    }
        
    function getOffice() {
        return $this->office;
    }

    function getDepartment() {
        return $this->department;
    }

    function getPosition() {
        return $this->position;
    }

    function getUsername() {
        return $this->username;
    }

    function getSeniority() {
        return $this->seniority;
    }

    function getAOName() {
        return $this->aoName;
    }

    function getCO1Name() {
        return $this->co1Name;
    }

    function getCO2Name() {
        return $this->co2Name;
    }

    function getPartAScore() {
        return $this->partAScore;
    }

    function getPartBScore() {
        return $this->partBScore;
    }

    function getTotalScore() {
        return $this->totalScore;
    }

    function getSelfStatus() {
        return $this->selfStatus;
    }

    function getAOStatus() {
        return $this->aoStatus;
    }

    function getCO1Status() {
        return $this->co1Status;
    }

    function getCO2Status() {
        return $this->co2Status;
    }

    function getLockStatus() {
        return $this->lockStatus;
    }

    function setOffice($office) {
        $this->office = $office;
    }

    function setDepartment($department) {
        $this->department = $department;
    }

    function setPosition($position) {
        $this->position = $position;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setSeniority($seniority) {
        $this->seniority = $seniority;
    }

    function setAOName($aoName) {
        $this->aoName = $aoName;
    }

    function setCO1Name($co1Name) {
        $this->co1Name = $co1Name;
    }

    function setCO2Name($co2Name) {
        $this->co2Name = $co2Name;
    }

    function setPartAScore($partAScore) {
        $this->partAScore = $partAScore;
    }

    function setPartBScore($partBScore) {
        $this->partBScore = $partBScore;
    }

    function setTotalScore($totalScore) {
        $this->totalScore = $totalScore;
    }

    function setSelfStatus($selfStatus) {
        $this->selfStatus = $selfStatus;
    }

    function setAOStatus($aoStatus) {
        $this->aoStatus = $aoStatus;
    }

    function setCO1Status($co1Status) {
        $this->co1Status = $co1Status;
    }

    function setCO2Status($co2Status) {
        $this->co2Status = $co2Status;
    }

    function setLockStatus($lockStatus) {
        $this->lockStatus = $lockStatus;
    }


}
