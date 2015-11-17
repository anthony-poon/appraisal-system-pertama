<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author user
 */
class login extends templatedHTML {
    public $error;
    //put your code here

    function defaultAction($param = NULL) {
        if (empty($_SESSION['user'])){
            unset($_SESSION);
            session_unset();
            $this->requestLogin();
        } else {
            header('Location: survey');
        }
    }

    function requestLogin($param = null) {
        if (is_a($param, "Exception")) {
            $this->error = $param->getMessage();
        } else if (isset($param['error'])) {
            $this->error = $param['error'];
        }
        $this->setContent();
        $this->view();
    }

    function logout() {
        unset($_SESSION);
        session_unset();
        $this->defaultAction();
    }
    
    function setContent(){
        $this->extraCSS = 'login.css';
        $this->content = 'login.php';
    }
    
    function submitLogin() {
        try {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                throw new Exception("Username or password missing");
            }
            $password = $_POST['password'];
            $username = $_POST['username'];
            $user = new userToken();
            if (!$user->verifyLogin($username, $password)) {
                throw new Exception("Username or password incorrect");
            }
            
            $_SESSION['user'] = serialize($user);
            //$_SESSION['browserInfo'] = get_browser(NULL);

            if (!empty($user->availiblePeriod)) {
                if (!empty($user->appraisee) || !empty($user->appraisee)) {
                    header('Location: survey');
                } else {
                    header('Location: survey?action=renderForm&r=self&uid='.$user->availiblePeriod['uid'].'&u='.$user->username);
                }
            } else if ($user->isAdmin) {
                header('Location: report');
            } else {
                throw new Exception('All surveys are closed at the moment. Please try again later.');
            }

        } catch (Exception $ex) {
            $this->requestLogin($ex);
        }
    }

}
