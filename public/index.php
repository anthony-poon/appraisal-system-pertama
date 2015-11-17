<?php
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(dirname(__FILE__)));
    if (isset($_GET['url'])) {
        $url = $_GET['url'];
    } else
        $url = null;
    require_once(ROOT.DS.'config'.DS.'config.php');
    require_once(ROOT.DS.'utility'.DS.'router.php');
    
