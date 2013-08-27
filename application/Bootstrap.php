<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initNavigation() {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml');
        
        $navigation = new Zend_Navigation($config);
        Zend_Registry::set('main',$navigation);
        
      
        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/admin_navigation.xml');
        $admin_navigation = new Zend_Navigation($config);
        Zend_Registry::set('admin',$admin_navigation);
        
    }

  
}

