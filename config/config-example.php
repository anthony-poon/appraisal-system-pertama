<?php
	// Need to rename into config.php
    define('DEVELOPMENT_ENVIRONMENT',true);    
    
    define('SITE_ROOT' , 'http://localhost');
    define('DEFAULT_CONTROLLER', "login");
    define('DEFAULT_ACTION', "defaultAction");
    define('DEFAULT_DB', "pa_survey");
    
    define('DBLOGPATH', ROOT.DS.'tmp'.DS.'logs'.DS);
    define('TEMPLATE', ROOT.DS."view".DS."template".DS);
    define('CSS', ROOT.DS."public".DS."css".DS);
    define('VIEW', ROOT.DS."view".DS);
    define('TEMP', ROOT.DS."tmp".DS);
    define('PASSWORD_MIN_CHAR', 4);
    $dbDriver = 'mysql';
    $dbHost = 'localhost';
    $dbUser = 'example';
    $dbPassword = 'example';