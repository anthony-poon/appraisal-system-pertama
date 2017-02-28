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
class AdminController extends PrivilegedZone{
    //put your code here    
    function __construct() {
        parent::__construct();
    }
    
    function defaultAction($param = NULL) {
        $this->adminPanel($param);
    }
    
    function adminPanel($param = NULL) {
        $this->extraCSS = array("compiled/admin_panel/default.css", "font-awesome.min.css");
        $this->content = "admin_panel/default.php";
        $this->header = "surveyHeader.php";
        //$this->commonCSS = "compiled";
        $param["uid"] = $this->user->activeUid;
        $this->view($param);
    }
    
    function userListView($param = NULL) {
        $this->extraCSS = array("compiled/admin_panel/user_list_view.css", "font-awesome.min.css", "material-kit.css");
        $this->extraJS = array("material-kit.js", "material.min.js");
        $this->content = "admin_panel/userListView.php";
        $this->header = "surveyHeader.php";
        $param["uid"] = $this->user->activeUid;
        $userFactory = new UserBatchOperator();
        if (!empty($param["show_inactive"])) {
            $userObjs = $userFactory->createUserObj(null, true);
        } else {
            $userObjs = $userFactory->createUserObj();
        }
        
        /* @var $user User */
        foreach ($userObjs as $user) {
            $param["users"][$user->getDepartment()][] = $user;
        }
        $this->view($param);
    }
    
    function viewUser($param = NULL) {
        $this->extraCSS = array("compiled/admin_panel/view_user.css", "font-awesome.min.css", "material-kit.css");
        $this->content = "admin_panel/viewUser.php";
        $this->header = "surveyHeader.php";
        $param["uid"] = $this->user->activeUid;
        $this->extraJS = array("material-kit.js", "material.min.js", "admin_panel/view_user.js", "moment.js");
        $userFactory = new UserBatchOperator();
        $param['user'] = $userFactory->createUserObj($param["user_id"]);
        $setting = new SettingFactory();
        $param["department_enum"] = $setting->getSetting("department");
        $param["office_enum"] = $setting->getSetting("office");
        $userArray = $userFactory->createUserObj();
        foreach ($userArray as $user) {
            /* @var $user User */
            $param["user_enum"][$user->getUsername()] = $user->getStaffName();
        }
        asort($param["user_enum"]);
        $this->view($param);
    }
    
    function submitUser($param = NULL) {
        $this->extraCSS = array("compiled/admin_panel/view_user.css", "font-awesome.min.css", "material-kit.css");
        $this->content = "testing.php";
        $this->header = "surveyHeader.php";
        $param["uid"] = $this->user->activeUid;
        $this->extraJS = array("material-kit.js", "material.min.js", "admin_panel/view_user.js", "moment.js");
        $userFactory = new UserBatchOperator();
        //$param ['user'] = $userFactory->createUserObj($param["user_id"]);
        if (!preg_match("/^\d+$/", $param["user_id"])) {
            throw new Exception("Invalid query: user_id");
        }
        $user = $userFactory->createUserObj($param["user_id"]);
        /* @var $user User */
        $user->setIsActive(FALSE);
        $user->setIsAdmin(FALSE);
        $user->setIsHidden(FALSE);
        $user->setIsReportUser(FALSE);
        $user->setIsSenior(FALSE);
        foreach ($_POST as $fieldName => $value) {
            if (!preg_match("/^[\w\-_\. ]+$/", $fieldName)) {
                throw new Exception("Invalid query: ".$fieldName);
            }
            if (!preg_match("/^[\w\-_\.@ ]*$/", $value)) {
                throw new Exception("Invalid query: ".$value);
            }
            switch ($fieldName) {
                case "staff_name":
                    $user->setStaffName(trim($value));
                    break;
                case "email":
                    $user->setEmail(trim($value));
                    break;
                case "is_senior":
                    $user->setIsSenior(TRUE);
                    break;
                case "is_admin":
                    $user->setIsAdmin(TRUE);
                    break;
                case "is_report_user":
                    $user->setIsReportUser(TRUE);
                    break;
                case "department":
                    $user->setDepartment(trim($value));
                    break;
                case "position":
                    $user->setPosition(trim($value));
                    break;
                case "office":
                    $user->setOffice(trim($value));
                    break;
                case "commence_date":
                    $date = DateTimeImmutable::createFromFormat("Y-m-d", trim($value));
                    if (!$date) {
                        throw new Exception("Invalid date format");
                    }
                    $user->setCommenceDate($date);
                    break;
                case "ao_username":
                    $user->setAoUsername(trim($value));
                    break;
                case "co_username_1":
                    $user->setCo1Username(trim($value));
                    break;
                case "co_username_2":
                    $user->setCo2Username(trim($value));
                    break;
                case "is_active":
                    $user->setIsActive(TRUE);
                    break;                    
            }
        }
        $userFactory->updateUser($user);
        $host  = $_SERVER['HTTP_HOST'];
        $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        ob_clean();
        header("Location: admin?action=viewUser&user_id=".$param["user_id"]);
        exit;
    }
    
    function changePWView($param = NULL){
        $this->extraCSS = "admin/change-pw.css";
        $this->content = "admin/changePw.php";
        $this->header = "sidebar.php";
        $this->commonCSS = "common-with-sidebar.css";
        $this->view($param);
    }
    
    function ajaxSelfPW($param = NULL) {
        try {
            if (empty($_POST["pwNew"]) || empty($_POST["pwConfirm"])) {
                throw new Exception("Password cannot be empty.");
            }
            $this->user->setPassword($_POST["pwNew"], $_POST["pwConfirm"]);
            if (!empty($_POST["shouldUnflag"])){
                $this->user->unflagForReset();
            }
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
            $userOperator = new UserBatchOperator();
            if (!$this->user->isAdmin) {
                throw new Exception("Access Denied");
            }
            $userOperator->adminSetPassword($param["userId"], $_POST["pwNew"], $_POST["pwConfirm"]);
            $result["error"] = 0;
            $result["msg"] = "Amendment is successful";
            
        } catch (Exception $ex) {
            $result["error"] = 1;
            $result["msg"] = $ex->getMessage();
        }
        echo json_encode($result);
    }
    
    function adminUserView($param = NULL) {
        $this->content = "admin/adminUser.php";
        $this->header = "sidebar.php";
        $this->commonCSS = "common-with-sidebar.css";
        $this->extraCSS = array("admin/admin-user.css");
        $userOperator = new UserBatchOperator();
        $param["userDetail"] = $userOperator->getUserFullData();
        ksort($param["userDetail"]);
        $param["fileCategory"] = $userOperator->getFileCategory();
        $this->view($param);
    }
    
    function uploadFileView($param = NULL) {
        $this->content = "admin/uploadFile.php";
        $this->header = "sidebar.php";
        $this->commonCSS = "common-with-sidebar.css";
        $this->extraCSS = array("admin/upload-file.css");
        $userOperator = new UserBatchOperator();
        $param["username"] = $userOperator->getUsername();
        ksort($param["username"]);
        $param["fileCategory"] = $userOperator->getFileCategory();
        $this->view($param);
    }
    
    function ajaxToggleStatus ($param = NULL){
        try {
            if (!$this->user->isAdmin) {
                throw new Exception("Access Denied");
            }
            $userOperator = new UserBatchOperator();
            $userOperator->toggleStatus($param["userId"]);
            $result["error"] = "0";
            $result["msg"] = "Account is toggled.";
        } catch (Exception $ex) {
            $result["error"] = "1";
            $result["msg"] = $ex->getMessage();
        }
        echo json_encode($result);
    }
    
    function firstTimeReset($param = NULL) {
        $this->commonCSS = "admin/first-time-pw.css";
        $this->content = "admin/firstTimePw.php";
        $this->view($param);
    }
    
    function uploadFile($param = NULL) {
        try {
            $postSize = intval(ini_get('post_max_size'))*1024*1024;
            $filesize = intval(ini_get('upload_max_filesize'))*1024*1024;
            if ((int) $_SERVER['CONTENT_LENGTH'] > $postSize || (int) $_SERVER['CONTENT_LENGTH'] > $filesize) {
                throw new Exception('File too large!');
            }
            
            If (!$this->user->isAdmin) {
                throw new Exception("Access denied. Not administrator");
            }
            
            if (empty($_POST["to"])) {
                throw new Exception("Missing missing username in query string");

            }
            
            if (!preg_match("/^([0-9a-zA-Z-_\.\(\)\+\s]+)$/", $_POST["to"])) {
                throw new Exception("Illegal target.");
            }            
            
            if (!preg_match("/^([0-9a-zA-Z-_\.\(\)\+\s\&]+)\.(\w+)$/", $_FILES['upfile']['name'])) {
                throw new Exception("Illegal file name.");
            }
            
            if (!empty($_POST["category"])) {
                if (!preg_match("/^([0-9a-zA-Z-_\.\(\)\+\s\&]+)$/", $_POST["category"])) {
                    throw new Exception("Illegal directory name.");
                }
                
            }
            $path = UPLOAD_DIR;
            if (!file_exists(UPLOAD_DIR.$_POST["to"])) {
                mkdir(UPLOAD_DIR.$_POST["to"]);
            }
            
            $path .= $_POST["to"]."/";
            if (!empty($_POST["category"]) && !file_exists($path.$_POST["category"])) {
                mkdir($path.$_POST["category"]);
                $path .= $_POST["category"]."/";
            } else if (!empty($_POST["category"])) {
                $path .= $_POST["category"]."/";
            }
            
            if (!is_array($_FILES['upfile']['name'])) {
                move_uploaded_file($_FILES['upfile']['tmp_name'], $path.$_FILES['upfile']['name']);
            } else {
                foreach ($_FILES['upfile']['name'] as $fileName) {
                    move_uploaded_file($_FILES['upfile']['tmp_name'], $path.$fileName);
                }
            }            
            $param["error"] = "Upload successful.";
            
        } catch (Exception $ex) {
            $param["error"] = $ex->getMessage();
        }
        $this->uploadFileView($param);
    }
    
    function documentView($param = NULL){
        if (empty($param["path"])) {
            // viewing root
            if ($this->user->isAdmin) {
                // Admin can see root dir
                $param["path"] = "";
            } else {
                // User can see root/"username" dir
                $param["path"] = $this->user->username;
            }
            $isViewingRoot = TRUE;
        } else {
            // Inside the folder tree, parsing path
            $param["path"] = preg_replace("/!/", "/", $param["path"]);
            $isViewingRoot = FALSE;
        }        
        $uploadRoot = new UploadedFolderParser($param["path"]);
        if (!$uploadRoot->isFileExist()) {
            
            if ($isViewingRoot) {
                $param["error_msg"] = "You currently do not have any document to view.";
            } else {
                $param["error_msg"] = "Error is query parameter. Check URL and file name.";
            }
            $this->commonCSS = "common-with-sidebar.css";
            $this->header = "sidebar.php";
            $this->extraCSS = "admin/my-doc.css";
            $this->content = "admin/myDocView.php";
            $this->view($param);
        } else {
            if ($uploadRoot->isRootAFolder()) {
                // If it is a folder structure
                $param["folder"] = $uploadRoot->getFolders();
                $param["file"] = $uploadRoot->getFiles();
                $this->commonCSS = "common-with-sidebar.css";
                $this->header = "sidebar.php";
                $this->extraCSS = "admin/my-doc.css";
                $this->content = "admin/myDocView.php";
                $this->view($param);
            } else {
                // If it is a single file, download
                header("Content-type: text/plain");
                header("Content-Disposition: attachment; filename=".$uploadRoot->getRootName());
                echo $uploadRoot->getRootContent();
            }
        }
    }
}
