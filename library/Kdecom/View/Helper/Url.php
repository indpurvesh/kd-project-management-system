<?php


/**
 * Helper for making easy links and getting urls that depend on the routes and router
 *
 * @package    Kdecom_View
 * @subpackage Helper
 * @license    Kdecom
 */
class Kdecom_View_Helper_Url extends Zend_View_Helper_Url
{
    
    
    public function url(array $urlOptions = array(), $name = null, $reset = false, $encode = true) {
        //parent::url($urlOptions, $name, $reset, $encode);
        
        //$url = $router->assemble($urlOptions, $name, $reset, $encode);
        
        //$url = "test".$url;
        return $this;
    }
    
    public function makeUrl(array $urlOptions = array(), $name = null, $reset = false, $encode = true) {
        $url =  parent::url($urlOptions, $name, $reset, $encode);
        
        return $this->siteUrl() . $url;
    }

    public function siteUrl(){
        return APPLICATION_BASE_URL;
    }
}
