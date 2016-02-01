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
abstract class TemplatedHTML implements IController {

    //put your code here
    public $header;
    public $footer;
    public $content;
    public $extraCSS;
    public $commonCSS;
    public $extraJS;

    function defaultAction($param = NULL) {
        $this->view();
    }

    function view($param = null) {
        
        if (!empty($this->content)) {
            echo "<!DOCTYPE html>";
            echo "<html>";
            echo "<head>";
            echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" charset=\"UTF-8\" />";
            echo "<link rel='shortcut icon' href='public/img/favicon.ico'>";
            if (!empty($this->commonCSS)) {
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"public/css/$this->commonCSS\">";  
            } else {
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"public/css/common.css\">";  
            }
            
            if (is_array($this->extraCSS)) {
                foreach ($this->extraCSS as $css) {
                    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"public/css/$css\">";  
                }
            } else if (!empty($this->extraCSS)) {             
                echo "<link rel='stylesheet' type='text/css' href='public/css/$this->extraCSS'>";
            }
            if (is_array($this->extraJS)) {
                foreach ($this->extraJS as $js) {
                    echo "<script type='text/javascript' src='public/js/$js'></script>";
                }
            } else if (!empty($this->extraJS)) {             
                echo "<script type='text/javascript' src='public/js/$this->extraJS'></script>";
            }
            
            echo "</head>";
            echo "<body>";
            if (!empty($this->header)) {
                require_once(TEMPLATE . "$this->header");
            }
            
            require_once(VIEW . $this->content);
            if (!empty($this->footer)) {
                require_once(TEMPLATE . "$this->footer");
            }
            require_once(TEMPLATE . "commonFooter.php");
            echo "</body>";
            echo "</html>";
        } else {
            echo "Content not set: <br>";
        }
    }

}
