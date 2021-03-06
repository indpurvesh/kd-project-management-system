<?php

/**
 * Description of Module
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
//  module/StickyNotes/Module.php

namespace Admin;

use Auth\Model\UserTable;
use Admin\Model\RoleTable;
use Admin\Model\AssignRoleActionTable;
use Admin\Model\ContactTypeTable;
use Admin\Model\ContactTable;
use Admin\Model\ProjectTable;
use Admin\Model\ProjectTypeTable,
    Admin\Model\StepTable
        ;
class Module {

     
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

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Admin\Model\CoreSystemSettingsTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    //$table = new Model\StickyNotesTable($dbAdapter);
                    $table = new Model\CoreSystemSettings($dbAdapter);
                    return $table;
                },
                'Admin\Model\UserTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\RoleTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new RoleTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\AssignRoleActionTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new AssignRoleActionTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\ContactTypeTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ContactTypeTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\ContactTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ContactTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\ProjectTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ProjectTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\ProjectTypeTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ProjectTypeTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\StepTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new StepTable($dbAdapter);
                    return $table;
                },
            ),
        );
    }

}
