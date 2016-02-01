<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mailFactory
 *
 * @author anthony.poon
 */
class MailFactory {
    //put your code here
    function testing() {
        $to = 'anthony.poon@asia-minerals.com';
        $subject = 'the subject';
        $message = 'hello';
        $headers = 'From: webmaster@asia-minerals.com' . "\n" .
            'Reply-To: webmaster@asia-minerals.com' . "\n" .
            "Return-Path: anthony.poon@asia-minerals.com\n".
            'X-Mailer: PHP/' . phpversion();

        return mail($to, $subject, $message, $headers);
    }
}
