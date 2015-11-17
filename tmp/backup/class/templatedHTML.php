<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of templatedHTML
 *
 * @author anthony.poon
 */
abstract class templatedHTML implements IController {

    //put your code here
    public $header;
    public $footer;
    public $content;
    public $extraCSS;

    public function defaultAction($param = NULL) {
        $this->view();
    }

    public function view($param = null) {
        if (!empty($this->content)) {
            require_once(TEMPLATE . "commonHeader.php");
            if (!empty($this->header)) {
                require_once(TEMPLATE . "$this->header");
            }
            require_once(VIEW . $this->content);
            if (!empty($this->footer)) {
                require_once(TEMPLATE . "$this->footer");
            }
            require_once(TEMPLATE . "commonFooter.php");
            
            if (!empty($this->extraCSS)) {
                echo "<link rel='stylesheet' type='text/css' href='public/css/$this->extraCSS'>";
            }
        } else {
            echo "Content not set: <br>";
        }
    }

}
