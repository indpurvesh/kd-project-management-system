<?php

class User_Form_Login extends Kdecom_Form_Base {

    public function init() {
        parent::init();
        $this->setName('login');
        $this->setMethod('post');
        $this->setAttrib('class','login-here');
        $this->_createFormElements();
        $this->_createButton();
    }

    private function _createButton() {
        $this->createElement('submit', 'login', 'Login')
                ->setAttrib('class', 'login-here-button');
        $this->addDisplayGroup(array($this->login), 'buttons');
    }

    private function _createFormElements() {
        
        $this->createElement('text', 'user_name', "User Name / Email (admin)")
                ->setRequired(true)
                ->setAttrib('class','login-here-input')
                ->addValidator('NotEmpty');
        
        $this->createElement('password', 'user_password', "Password (admin123)")
                ->setRequired(true)
                ->setAttrib('class','login-here-input')
                ->addValidator('NotEmpty');
        
      
        $this->addDisplayGroup(
                array(
            $this->user_name,
            $this->user_password
                ), 'FormElemts');
    }

}