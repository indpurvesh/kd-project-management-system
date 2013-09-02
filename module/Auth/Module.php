<?php

namespace Auth;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage,
    Auth\Model\UserTable;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'auth_service' => function ($sm) {
                    $authService = new AuthenticationService(new SessionStorage('Zend_Auth'));
                    return $authService;
                },
               'Auth\Model\UserTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    //$table = new Model\StickyNotesTable($dbAdapter);
                    $table = new UserTable($dbAdapter);
                    return $table;
                },
            )
        );
    }

}
