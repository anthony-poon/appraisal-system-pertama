<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PhpMailerFactory
 *
 * @author anthony.poon
 */
class PhpMailerFactory {
    //put your code here
    public $mailer;
    function __construct() {
        require(PLUGIN."phpmailer".DS."PHPMailerAutoload.php");
        $this->mailer = new PHPMailer;
        //$this->mailer->SMTPDebug = 3; 
        $this->mailer->isSMTP();
        $this->mailer->Host = SMTP_SERVER;  // Specify main and backup SMTP servers
        $this->mailer->SMTPAuth = SMTP_AUTH_REQUIRE;                               // Enable SMTP authentication
        $this->mailer->Username = SMTP_USERNAME;                 // SMTP username
        $this->mailer->Password = SMTP_PASSWORD;                           // SMTP password
        $this->mailer->SMTPSecure = SMTP_ENCRYPTION;                            // Enable TLS encryption, `ssl` also accepted
        $this->mailer->Port = 587;                                    // TCP port to connect to
        $this->mailer->setFrom(WEB_MASTER_ADDRESS, WEB_MASTER_NAME);
        $this->mailer->isHTML(true);                                  // Set email format to HTML
    }
    
    function appraiseeSubmmitEmail($submitter, $receiver, $to) {
        $this->mailer->ClearAllRecipients();
        if (is_array($to)) {
            foreach ($to as $recp) {
                $this->mailer->addAddress($recp);
            }            
        } else {
            $this->mailer->addAddress($to);
        }
        
        $this->mailer->Subject = $submitter." has completed his/her self-assessment part of the appraisal";
        
        $this->mailer->Body = "<p>Dear $receiver,</p><br/>".
            "<p>Your Appraisee, $submitter, had just submitted his/her self-assessment part of the appraisal. You can review it by logging into the following link: </p>".
            "<p>".SITE_ROOT."</p>".
            "<p>Please complete the remaining part of the appraisal for your Appraisee.</p><br/>".
            "<p>[This is a system generated message.]</p>";
        $this->mailer->AltBody = "Dear $receiver,\r\n".
            "\r\n".
            "Your Appraisee, $submitter, had just submitted his/her self-assessment part of the appraisal. You can review it by logging into the following link: \r\n".
            "\r\n".
            SITE_ROOT.
            "\r\n\r\n".
            "Please complete the remaining part of the appraisal for your Appraisee.\r\n\r\n".
            "[This is a system generated message.]";
        
        $timeStamp = date('m/d/Y h:i:s a', time());
        if(!$this->mailer->send()) {
            file_put_contents(LOG."mail.log","[".$timeStamp."] ", FILE_APPEND);
            file_put_contents(LOG."mail.log", "Message could not be sent. ", FILE_APPEND);
            file_put_contents(LOG."mail.log", $this->mailer->ErrorInfo."\n", FILE_APPEND);
        } else {
            file_put_contents(LOG."mail.log","[".$timeStamp."] ", FILE_APPEND);
            if (is_array($to)) {
                file_put_contents(LOG."mail.log", "Message sent to ".implode(", " , $to).".\n", FILE_APPEND);
            } else {
                file_put_contents(LOG."mail.log", "Message sent to ".$to.".\n", FILE_APPEND);
            }
        }
    }
    
    function appraiserSubmmitEmail($submitter, $receiver, $to) {
        if (is_array($to)) {
            foreach ($to as $recp) {
                $this->mailer->addAddress($recp);
            }            
        } else {
            $this->mailer->addAddress($to);
        }
        
        $this->mailer->Subject = $submitter." has completed the appraisal on you.";
        
        $this->mailer->Body = "<p>Dear $receiver,</p><br/>".
            "<p>Your Appraising Officer, had just completed his/her appraisal on you. You can review it by logging into the following link:</p>".
            "<p>".SITE_ROOT."</p>".
            "<p>Please complete the remaining part which is for your self-assessment.</p><br/>".
            "<p>[This is a system generated message.]</p>";
        $this->mailer->AltBody = "Dear $receiver,\r\n".
            "\r\n".
            "Your Appraising Officer, had just completed his/her appraisal on you. You can review it by logging into the following link: \r\n".
            "\r\n".
            SITE_ROOT.
            "\r\n\r\n".
            "Please complete the remaining part which is for your self-assessment.\r\n\r\n".
            "[This is a system generated message.]";
        
        $timeStamp = date('m/d/Y h:i:s a', time());
        if(!$this->mailer->send()) {
            file_put_contents(LOG."mail.log","[".$timeStamp."] ", FILE_APPEND);
            file_put_contents(LOG."mail.log", "Message could not be sent. ", FILE_APPEND);
            file_put_contents(LOG."mail.log", $this->mailer->ErrorInfo."\n", FILE_APPEND);
        } else {
            file_put_contents(LOG."mail.log","[".$timeStamp."] ", FILE_APPEND);
            if (is_array($to)) {
                file_put_contents(LOG."mail.log", "Message sent to ".implode(", " , $to).".\n", FILE_APPEND);
            } else {
                file_put_contents(LOG."mail.log", "Message sent to ".$to.".\n", FILE_APPEND);
            }
        }
    }
    
    function formLockEmail($appraiseeName, $appraiserName, $to) {
        if (is_array($to)) {
            foreach ($to as $recp) {
                $this->mailer->addAddress($recp);
            }            
        } else {
            $this->mailer->addAddress($to);
        }
        
        $this->mailer->Subject = "$appraiseeName's appraisal is submitted for review";
        
        $this->mailer->Body = "<p>Dear $appraiseeName and $appraiserName,</p><br/>".
            "<p>The Appraisal form for $appraiseeName is fully completed and submitted. The form is now being locked and no further amendment is allowed.</p>".
            "<p>You can review it again any time by logging into the following link:</p>".
            "<p>".SITE_ROOT."</p><br/>".
            "<p>[This is a system generated message.]</p>";
        $this->mailer->AltBody = "Dear $appraiseeName and $appraiserName,\r\n".
            "\r\n".
            "The Appraisal form for $appraiseeName is fully completed and submitted. The form is now being locked and no further amendment is allowed.\r\n\r\n".
            "You can review it again any time by logging into the following link: \r\n\r\n".
            SITE_ROOT." \r\n\r\n".
            "[This is a system generated message.]";
        
        $timeStamp = date('m/d/Y h:i:s a', time());
        if(!$this->mailer->send()) {
            file_put_contents(LOG."mail.log","[".$timeStamp."] ", FILE_APPEND);
            file_put_contents(LOG."mail.log", "Message could not be sent. ", FILE_APPEND);
            file_put_contents(LOG."mail.log", $this->mailer->ErrorInfo."\n", FILE_APPEND);
        } else {
            file_put_contents(LOG."mail.log","[".$timeStamp."] ", FILE_APPEND);
            if (is_array($to)) {
                file_put_contents(LOG."mail.log", "Message sent to ".implode(", " , $to).".\n", FILE_APPEND);
            } else {
                file_put_contents(LOG."mail.log", "Message sent to ".$to.".\n", FILE_APPEND);
            }
        }
    }
}
