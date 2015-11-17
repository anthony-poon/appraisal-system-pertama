<?php

/** Check if environment is development and display errors * */
session_start();

function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
    }
}

//Automatically includes files containing classes that are called
function autoloader($className) {
    //fetch file
    if (file_exists(ROOT . DS . 'class' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'class' . DS . $className . '.php');
        return true;
    } else {
        // Error: Controller Class not found
        return false;
    }
}

/** Main Call Function * */
function callHook() {
    global $url;
    if (!isset($url)) {
        $controllerName = DEFAULT_CONTROLLER;
        $action = DEFAULT_ACTION;
    } else {
        $param = $_GET;
        $pathToController = ROOT . DS . 'controller' . DS;
        $urlArray = array();
        $urlArray = explode("/", $url);
        unset($param["url"]);
        for ($i = 0; $i < (count($urlArray) - 1); $i++) {
            $pathToController .= $urlArray[$i] . DS;
        }
        $controllerName = $urlArray[count($urlArray) - 1];
        if ($controllerName == "") {
            $controllerName = DEFAULT_CONTROLLER;
        }
        if (isset($_GET["action"])) {
            $action = $_GET["action"];
            unset($param["action"]);
        } else {
            $action = DEFAULT_ACTION;
        }
    }
    if (file_exists($pathToController . $controllerName . ".php")) {
        require_once($pathToController . $controllerName . ".php");
        $controller = new $controllerName;
        if (method_exists($controller, $action)) {
            if (empty($param)) {
                $controller->$action();
            } else {
                $controller->$action($param);
            }
        } else {
            echo "action : " . $controllerName . "->" . $action . " not found";
        }
    } else {
        echo "controller : " . $pathToController . $controllerName . ".php not found";
    }
}

function logHeader() {
    $headerArray = apache_request_headers();
    $timeStamp = date('m/d/Y h:i:s a', time());
    file_put_contents(TEMP.DS."logs".DS."header.log","[".$timeStamp."]\n", FILE_APPEND);

    foreach ($headerArray as $header => $value) {
        $str = $header." => ".$value."\n";
        file_put_contents(TEMP.DS."logs".DS."header.log",$str, FILE_APPEND);
    }
    file_put_contents(TEMP.DS."logs".DS."header.log","\n", FILE_APPEND);
}

function logPOST() {
    if (!empty($_POST)) {
        $timeStamp = date('m/d/Y h:i:s a', time());
        file_put_contents(TEMP.DS."logs".DS."post.log","[".$timeStamp."]\n", FILE_APPEND);
        file_put_contents(TEMP.DS."logs".DS."post.log","http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]\n", FILE_APPEND);
        foreach ($_POST as $varName => $value) {
            $str = "\$_POST['".$varName."'] => ".$value."\n";
            file_put_contents(TEMP.DS."logs".DS."post.log",$str, FILE_APPEND);
        }
        file_put_contents(TEMP.DS."logs".DS."post.log","\n", FILE_APPEND);
    }
}

setReporting();
spl_autoload_register('autoloader');
if (DEVELOPMENT_ENVIRONMENT) {
    //logHeader();
    logPOST();
}
callHook();


