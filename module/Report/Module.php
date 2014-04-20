<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Report;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Admin\Model\ContactTable;
use Auth\Model\UserTable;

class Module {

    public function onBootstrap(MvcEvent $e) {


        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
                    $controller = $e->getTarget();
                    $controllerClass = get_class($controller);
                    $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
                    $config = $e->getApplication()->getServiceManager()->get('config');
                    if (isset($config['module_layouts'][$moduleNamespace])) {
                        $controller->layout($config['module_layouts'][$moduleNamespace]);
                    }
                }, 100);
        
        	$moduleRouteListener = new ModuleRouteListener();
        	$moduleRouteListener->attach($eventManager);
        
        	$eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'init', function($e) {}, 10);
        	$moduleRouteListener = new ModuleRouteListener();
        	$moduleRouteListener->attach($eventManager);



        
    }

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
            		'Admin\Model\ContactTable' => function($sm) {
            			$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            			$table = new ContactTable($dbAdapter);
            			return $table;
            		},
            		'Auth\Model\UserTable' => function($sm) {
            			$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            			$table = new UserTable($dbAdapter);
            			return $table;
            		},
                
            )
        );
    }

}
