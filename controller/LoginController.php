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
class LoginController extends TemplatedHTML {
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
            header('HTTP/1.0 403 Forbidden', TRUE, 403);
            $this->error = $param->getMessage();
        } else if (isset($param['error'])) {
            header('HTTP/1.0 403 Forbidden', TRUE, 403);
            if ($param['error'] == 403) {
                $this->error = "Access denied. Please login first.";
            } elseif ($param['error'] == "disabled") {
                $this->error = "Account disabled. Please contact administrators.";
            }
        }
        $this->extraCSS = 'login.css';
        $this->content = 'login.php';
        $this->view();
    }

    function logout() {
        unset($_SESSION);
        session_unset();
        $this->defaultAction();
    }
    
    function submitLogin() {
        try {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                throw new Exception("Username or password missing");
            }
            $user = new UserToken();
            if (!$user->verifyLogin($_POST['username'], $_POST['password'])) {
                throw new Exception("Username or password incorrect");
            }            
            $_SESSION['user'] = serialize($user);
            if ($user->isFlaggedForPwReset) {
                header("Location: admin?action=firstTimeReset");
            } else {
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
            }

        } catch (Exception $ex) {
            header('HTTP/1.0 403 Forbidden', TRUE, 403);
            $this->requestLogin($ex);
        }
    }
    
    function keepAlive($param = null) {
        if (isset($_SESSION['id'])) {
            $_SESSION['id'] = $_SESSION['id'];
        }
    }
}
