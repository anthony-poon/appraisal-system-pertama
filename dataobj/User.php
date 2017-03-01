<?php

class User {
    //put your code here
    private $userID;
    private $username;
    private $staffName;
    private $email;
    private $isSenior = false;
    private $isAdmin = false;
    private $isReportUser = false;
    private $department;
    private $position;
    private $office;
    private $commenceDate;
    private $aoUsername;
    private $aoName;
    private $co1Username;
    private $co1Name;
    private $co2Username;
    private $co2Name;
    private $isActive = false;
    private $isHidden = false;
    private $isResetFlagged;
    
    public function __construct($sqlArray = null) {
        if ($sqlArray) {
            foreach ($sqlArray as $key => $value) {
                switch ($key) {
                    case "user_id":
                        $this->userID = $value;
                        break;
                    case "username":
                        $this->username = $value;
                        break;
                    case "user_full_name":
                        $this->staffName = $value;
                        break;
                    case "user_email":
                        $this->email = $value;
                        break;
                    case "is_senior":
                        $this->isSenior = ($value === "1");
                        break;
                    case "is_admin":
                        $this->isAdmin = ($value === "1");
                        break;
                    case "is_report_user":
                        $this->isReportUser = ($value === "1");
                        break;
                    case "user_department":
                        $this->department = $value;
                        break;
                    case "user_position":
                        $this->position = $value;
                        break;
                    case "user_office":
                        $this->office= $value;
                        break;
                    case "commence_date":
                        $this->commenceDate = DateTimeImmutable::createFromFormat("Y-m-d", $value);
                        break;
                    case "appraiser_username":
                        $this->aoUsername = $value;
                        break;
                    case "appraiser_name":
                        $this->aoName = $value;
                        break;
                    case "countersigner_username_1":
                        $this->co1Username = $value;
                        break;
                    case "countersigner_1_name":
                        $this->co1Name = $value;
                        break;
                    case "countersigner_username_2":
                        $this->co2Username = $value;
                        break;
                    case "countersigner_1_name";
                        $this->co1Name = $value;
                        break;
                    case "countersigner_2_name":
                        $this->co2Name = $value;
                        break;
                    case "is_active":
                        $this->isActive = ($value === "1");
                        break;
                    case "is_hidden":
                        $this->isHidden = ($value === "1");
                        break;
                    case "is_flagged_for_pw_reset":
                        $this->isResetFlagged = ($value === "1");
                        break;
                }
            }
        }
    }
    
    function getUserID() {
        return $this->userID;
    }

    function getUsername() {
        return $this->username;
    }

    function getStaffName() {
        return $this->staffName;
    }

    function getEmail() {
        return $this->email;
    }

    function getIsSenior() {
        return $this->isSenior;
    }

    function getIsAdmin() {
        return $this->isAdmin;
    }

    function getIsReportUser() {
        return $this->isReportUser;
    }

    function getDepartment() {
        return $this->department;
    }

    function getPosition() {
        return $this->position;
    }

    function getOffice() {
        return $this->office;
    }

    function getCommenceDate() {
        return $this->commenceDate;
    }
    
    function getCommenceDateStr() {
        if (!empty($this->commenceDate)) {
            return $this->commenceDate->format("Y-m-d");
        } else {
            return "";
        }
    }

    function getAoUsername() {
        return $this->aoUsername;
    }

    function getAoName() {
        return $this->aoName;
    }

    function getCo1Username() {
        return $this->co1Username;
    }

    function getCo1Name() {
        return $this->co1Name;
    }

    function getCo2Username() {
        return $this->co2Username;
    }

    function getCo2Name() {
        return $this->co2Name;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getIsHidden() {
        return $this->isHidden;
    }

    function getIsResetFlagged() {
        return $this->isResetFlagged;
    }

    function setUserID($userID) {
        $this->userID = $userID;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setStaffName($staffName) {
        $this->staffName = $staffName;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setIsSenior($isSenior) {
        $this->isSenior = $isSenior;
    }

    function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }

    function setIsReportUser($isReportUser) {
        $this->isReportUser = $isReportUser;
    }

    function setDepartment($department) {
        $this->department = $department;
    }

    function setPosition($position) {
        $this->position = $position;
    }

    function setOffice($office) {
        $this->office = $office;
    }

    function setCommenceDate(DateTimeImmutable $commenceDate = null) {
        $this->commenceDate = $commenceDate;
    }

    function setAoUsername($aoUsername) {
        $this->aoUsername = $aoUsername;
    }

    function setAoName($aoName) {
        $this->aoName = $aoName;
    }

    function setCo1Username($co1Username) {
        $this->co1Username = $co1Username;
    }

    function setCo1Name($co1Name) {
        $this->co1Name = $co1Name;
    }

    function setCo2Username($co2Username) {
        $this->co2Username = $co2Username;
    }

    function setCo2Name($co2Name) {
        $this->co2Name = $co2Name;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setIsHidden($isHidden) {
        $this->isHidden = $isHidden;
    }

    function setIsResetFlagged($isResetFlagged) {
        $this->isResetFlagged = $isResetFlagged;
    }
}
