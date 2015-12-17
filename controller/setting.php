<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of setting
 *
 * @author anthony.poon
 */
class setting extends privilegedZone{
    //put your code here    
    function __construct() {
        parent::__construct();
    }
    
    function defaultAction($param = NULL) {
        $this->changePWView($param);
    }
    
    function changePWView($param = NULL){
        $this->extraCSS = "change-pw.css";
        $this->content = "setting/change-pw.php";
        $this->header = "sidebar.php";
        $this->commonCSS = "common-with-sidebar.css";
        $this->view($param);
    }
    
    function submitPW($param = NULL) {
        $this->extraCSS = "change-pw.css";
        $this->content = "setting/change-pw.php";
        $this->header = "sidebar.php";
        $this->commonCSS = "common-with-sidebar.css";
        try {
            $this->user->setPassword($_POST["pw-new"], $_POST["pw-new"]);
            $param["msg"] = "Password change succeed";
            $this->view($param);
        } catch (Exception $ex) {
            $param["msg"] = $ex->getMessage();
            $this->view($param);
        }
    }
    
    function ajaxSelfPW($param = NULL) {
        try {
            if (empty($_POST["pwNew"]) || empty($_POST["pwConfirm"])) {
                throw new Exception("Password cannot be empty.");
            }
            $this->user->setPassword($_POST["pwNew"], $_POST["pwConfirm"]);
            $result["error"] = 0;
            $result["msg"] = "Amendment is successful";
        } catch (Exception $ex) {
            $result["error"] = 1;
            $result["msg"] = $ex->getMessage();
        }
        echo json_encode($result);
    }
    
    function ajaxAdminPW($param = NULL) {
        try {
            if (empty($_POST["pwNew"]) || empty($_POST["pwConfirm"])) {
                throw new Exception("Password cannot be empty.");
            }
            $userOperator = new userBatchOperator();
            if (!$this->user->isAdmin) {
                throw new Exception("Access Denied");
            }
            $userOperator->adminSetPassword($_POST["userId"], $_POST["pwNew"], $_POST["pwConfirm"]);
            $result["error"] = 0;
            $result["msg"] = "Amendment is successful";
        } catch (Exception $ex) {
            $result["error"] = 1;
            $result["msg"] = $ex->getMessage();
        }
        echo json_encode($result);
    }
    
    function adminUserView($param = NULL) {
        $this->extraCSS = "admin-user.css";
        $this->content = "setting/admin-user.php";
        $this->header = "sidebar.php";
        $this->commonCSS = "common-with-sidebar.css";
        $userOperator = new userBatchOperator();
        $param["userDetail"] = $userOperator->getUserFullData();
        $this->view($param);
    }
}
