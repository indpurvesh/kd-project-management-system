<?php
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

class TestController extends Zend_Test_PHPUnit_ControllerTestCase
{
    /**
     * @var Zend_Application
    */
    protected $application;
    
    public function setUp() {
        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
        define('APPLICATION_URL', 'www.localhost.com/kd-step');
    }
    
    public function appBootstrap() {
        $this->application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->application->bootstrap();
        
         //$this->dispatch(APPLICATION_URL . "user");

        //$this->assertModule('user');
        //$this->assertController('appointment');
        //$this->assertAction('notification-bar-dialog');
        //$this->assertNotRedirect();
        //$this->assertValidHtml5();
    }
    
     public function testIndexAction() {

        $this->dispatch('/');

        $this->assertModule('workflow');
        $this->assertController('appointment');
        $this->assertAction('notification-bar-dialog');
        $this->assertNotRedirect();
        $this->assertValidHtml5();

    }
}
