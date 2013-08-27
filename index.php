<?php
define('APPLICATION_URL', 'http://www.localhost.com/kd-step');
define('APPLICATION_BASE_URL', 'http://www.localhost.com');
define('MEDIA_PATH', __DIR__ . "/media");
define('HOME_DIR', __DIR__);



//define('APPLICATION_URL', 'http://www.tagmyjob.co.nz/game');
//define('MEDIA_PATH', 'C:\media');


// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));


// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'library/Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
ini_set('display_errors', 1);
$application->bootstrap()
            ->run();