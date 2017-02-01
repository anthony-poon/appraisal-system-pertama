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
    
    function appraiseeSubmmitEmail($submitter, $receiver, $to) {
        if (is_array($to)) {
            $to = implode(",", $to);
        }
        
        $subject = $submitter." has completed his/her self-assessment part of the appraisal";
        
        $message = "Dear $receiver,\r\n".
            "\r\n".
            "Your Appraisee, $submitter, had just submitted his/her self-assessment part of the appraisal. You can review it by logging into the following link: \r\n".
            "\r\n".
            "http://eoffice.asia-minerals.com/pertama/pa_demo/".
            "\r\n\r\n".
            "Please complete the remaining part of the appraisal for your Appraisee.\r\n\r\n".
            "[This is a system generated message.]";
        $headers = 'From: Webmaster<webmaster@asia-minerals.com>' . "\n" .
            'Reply-To: webmaster@asia-minerals.com' . "\n" .
            "Return-Path: anthony.poon@asia-minerals.com\n".
            'X-Mailer: PHP/' . phpversion();
        return mail($to, $subject, $message, $headers);
    }
    
    function appraiserSubmmitEmail($submitter, $receiver, $to) {
        if (is_array($to)) {
            $to = implode(",", $to);
        }
        
        $subject = $submitter." has completed the appraisal on you.";
        
        $message = "Dear $receiver,\r\n".
            "\r\n".
            "Your Appraising Officer, had just completed his/her appraisal on you. You can review it by logging into the following link: \r\n".
            "\r\n".
            "http://eoffice.asia-minerals.com/pertama/pa_demo/".
            "\r\n\r\n".
            "Please complete the remaining part which is for your self-assessment.\r\n\r\n".
            "[This is a system generated message.]";
        $headers = 'From: Webmaster<webmaster@asia-minerals.com>' . "\n" .
            'Reply-To: webmaster@asia-minerals.com' . "\n" .
            "Return-Path: anthony.poon@asia-minerals.com\n".
            'X-Mailer: PHP/' . phpversion();
        return mail($to, $subject, $message, $headers);
    }
    
    function formLockEmail($appraiseeName, $appraiserName, $to) {
        if (is_array($to)) {
            $to = implode(",", $to);
        }
        
        $subject = "$appraiseeName's appraisal is submitted for review";
        
        $message = "Dear $appraiseeName and $appraiserName,\r\n".
            "\r\n".
            "The Appraisal form for $appraiseeName is fully completed and submitted. The form is now being locked and no further amendment is allowed.\r\n\r\n".
            "You can review it again any time by logging into the following link: \r\n\r\n".
            "http://eoffice.asia-minerals.com/pertama/pa_demo/ \r\n\r\n".
            "[This is a system generated message.]";
        $headers = 'From: Webmaster<webmaster@asia-minerals.com>' . "\n" .
            'Reply-To: webmaster@asia-minerals.com' . "\n" .
            "Return-Path: anthony.poon@asia-minerals.com\n".
            'X-Mailer: PHP/' . phpversion();
        return mail($to, $subject, $message, $headers);
    }
}
