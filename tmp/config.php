<?php

    define('DEVELOPMENT_ENVIRONMENT',true);    
    
    define('SITE_ROOT' , 'http://localhost');
    define('DEFAULT_CONTROLLER', "login");
    define('DEFAULT_ACTION', "defaultAction");
    define('DEFAULT_DB', "pa_survey");
    
    define('DBLOGPATH', ROOT.DS.'tmp'.DS.'logs'.DS);
    define('TEMPLATE', ROOT.DS."view".DS."template".DS);
    define('CSS', ROOT.DS."public".DS."css".DS);
    define('VIEW', ROOT.DS."view".DS);
    $dbDriver = 'mysql';
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPassword = 'Asiaminerals09';