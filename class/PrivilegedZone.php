<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ICredential
 *
 * @author user
 */
abstract class PrivilegedZone extends TemplatedHTML{
    //put your code here
    public $user;
    
    function __construct() {
        if (session_id() == "") {
            session_start();
        }
        if (!$this->isPrivileged()) {
            if ($this->user->isActive === "0") {
                header('Location: login?action=requestLogin&error=disabled');
            } else {
                header('Location: login?action=requestLogin&error=403');
            }
        }
    }
    
    function isPrivileged(){
        if (!empty($_SESSION['user'])){
            $this->user = unserialize($_SESSION['user']);
            if ($this->user->isActive) {
                return true;
            } else {
                return false;
            }
        } else {            
            return false;
        }
    }
    

}
