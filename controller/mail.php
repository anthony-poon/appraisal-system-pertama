<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mail
 *
 * @author anthony.poon
 */
class mail {
    //put your code here
    function test() {
        require_once __DIR__.'/../vendor/autoload.php';
        $mailer = new mailFactory();
        $result = $mailer->testing();
        var_dump($result);
    }
}
