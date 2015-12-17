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
class mailFactory {
    //put your code here
    function testing() {
        $message = Swift_Message::newInstance()
        ->setSubject('Your subject')
        ->setFrom(array('john@doe.com' => 'John Doe'))
        ->setTo(array('anthony.poon@asia-minerals.com'))
        // Give it a body
        ->setBody('Testing');
        $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
        $mailer = Swift_Mailer::newInstance($transport);
        $result = $mailer->send($message);
        return $result;
    }
}
