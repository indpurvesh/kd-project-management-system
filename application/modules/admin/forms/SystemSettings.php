<?php

class Admin_Form_SystemSettings extends Kdecom_Form_Base {

    public function init() {
        
        //$this->setAction(APPLICATION_URL."/employer/index/update-my-account");
        $this->setName('SystemSettings');
        $this->_createFormElements();
    }

    private function _createFormElements() {
        
        $this->createElement('hidden', 'id')
                ->setValue('1');
        // system settings cannt be able to insert it .....
        $this->createElement('text', 'application_name', "Application Name");


        $this->createElement('submit', 'submit', "Update");
        $this->createElement('button', 'cancel', "Cancel");

        $this->addDisplayGroup(array(
            $this->application_name,
                ), "System_Settings");
        $this->addDisplayGroup(array(
            $this->submit,
            $this->cancel
                ), "Buttons");
    }

    public function populate($data) {
        parent::populate($data);
    }

}