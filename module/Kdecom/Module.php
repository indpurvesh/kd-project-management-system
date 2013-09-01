<?php

namespace Kdecom;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
AutoloaderProviderInterface, ConfigProviderInterface, ServiceProviderInterface {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
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
                }
            )
        );
        
    }

    public function getConfig($env = null) {
        return include __DIR__ . '/config/module.config.php';
    }

}
