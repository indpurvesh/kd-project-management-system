<?php

class User_IndexController extends Kdecom_Controller_Action {

    public function init() {
        parent::init($auth = false);
    }

    public function indexAction() {
        
    }

    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect(APPLICATION_URL . '/user/index/login');
    }

    public function loginAction() {
        
        $this->view->form = Kdecom_Form_Base::factory('User_Form_Login');
        $this->disableLayout();
        
        
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            unset($data['login']);
            $userModel = new Application_Model_Table_Users();
            if ($userModel->auth($data) === true) {
                $this->_redirect('/');
            }
            // user name and password is wrong;;;
        }
    }

   

}

