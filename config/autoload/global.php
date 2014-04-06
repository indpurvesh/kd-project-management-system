<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
// config/autoload/global.php
if ($_SERVER['HTTP_HOST'] == "www.kdstep.com") {
    return array(
        'db' => array(
            'driver' => 'Pdo',
            'dsn' => 'mysql:dbname=kdstep;host=localhost',
            'username' => 'root',
            'password' => 'root',
            'driver_options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            ),
        ),
        'service_manager' => array(
            'factories' => array(
                'Zend\Db\Adapter\Adapter'
                => 'Zend\Db\Adapter\AdapterServiceFactory',
            ),
        ),
        'module_layouts' => array(
            'Application' => 'layout/front/layout.phtml',
            'Admin' => 'layout/admin/layout.phtml',
            'Auth' => 'layout/front/layout.phtml',
        ),
    );
} else {
    return array(
        'db' => array(
            'driver' => 'Pdo',
            'dsn' => 'mysql:dbname=cucch_13700871_kdpos;host=sql305.byetcluster.com',
            'username' => 'cucch_13700871',
            'password' => 'auckland',
            'driver_options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            ),
        ),
        'service_manager' => array(
            'factories' => array(
                'Zend\Db\Adapter\Adapter'
                => 'Zend\Db\Adapter\AdapterServiceFactory',
            ),
        ),
        'module_layouts' => array(
            'Application' => 'layout/front/layout.phtml',
            'Admin' => 'layout/admin/layout.phtml',
            'Auth' => 'layout/front/layout.phtml',
        ),
    );
}