<?php
	// Need to rename into config.php
    define('DEVELOPMENT_ENVIRONMENT',true);    
    
    define('SITE_ROOT' , 'http://127.0.0.1/');
    define('DEFAULT_CONTROLLER', "login");
    define('DEFAULT_ACTION', "defaultAction");
    define('DEFAULT_DB', "pa");
    define('COMPANY_NAME', "Company Name");
    define('UPLOAD_DIR', ROOT.DS.'asset'.DS.'upload'.DS);
    define('LOG', ROOT.DS.'tmp'.DS.'logs'.DS);
    define('TEMPLATE', ROOT.DS."view".DS."template".DS);
    define('PLUGIN', ROOT.DS."plugin".DS);
    define('CSS', ROOT.DS."public".DS."css".DS);
    define('VIEW', ROOT.DS."view".DS);
    define('TEMP', ROOT.DS."tmp".DS);
    define('PASSWORD_MIN_CHAR', 4);
    define('ENABLE_FILE_UPLOAD', TRUE);
    define("SURVEY_UID", 1);
    define("SMTP_SERVER", "mail.example.com");
    define("SMTP_AUTH_REQUIRE", TRUE);
    define("SMTP_USERNAME", 'root@example.com');
    define("SMTP_PASSWORD", 'password');
    define("SMTP_ENCRYPTION", 'tls');
    define("SMTP_PORT", 587);
    define("WEB_MASTER_ADDRESS", 'webmaster@example.com');
    define("WEB_MASTER_NAME", 'webmaster');
    
    $dbDriver = 'mysql';
    $dbHost = 'localhost';
    $dbUser = 'pa';
    $dbPassword = 'password';