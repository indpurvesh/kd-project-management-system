<?php

class Admin_Form_EmployeeEdit extends Kdecom_Form_Base {

    public function init() {
        //$this->setAction(APPLICATION_URL."/employer/index/update-my-account");
        $this->setName('EmployerEditAccount');
        $this->_createFormElements();
        parent::init();
        
    }

    private function _createFormElements() {
        
        $this->createElement('hidden', 'id');
               
        // system settings cannt be able to insert it .....
        $this->createElement('text', 'first_name', "First Name")
                ->setRequired(true)
                ->addValidator('NotEmpty');
        $this->createElement('text', 'last_name', "Last Name");

        

        $url = $this->getView()->url()->makeUrl(
                array(
                    'module' => 'admin' , 
                    'controller' => 'employee',
                    'action' => 'index'
                    ),null,true);
        
        
        $this->createElement('submit', 'submit', "Submit");
        $this->createElement('button', 'cancel', "Cancel")
                ->setAttrib("onclick", "location='".$url . "'");

        $this->addDisplayGroup(array(
            $this->first_name,
            $this->last_name
                ), "EmployeeEdit");
        
        $editGroup = $this->getDisplayGroup('EmployeeEdit');
        $this->addAttibuteElementToGroup($belongsToId = 1,$editGroup);
        
        $this->addDisplayGroup(array(
            $this->submit,
            $this->cancel
                ), "Buttons");
    }

    public function populate($data) {
        
        
        if($data['id'] != "" && $data['id'] >= 1 ) {
            $this->assignAttibuteElementToValue($data['id'], $belongsToId = 1);
        }
        parent::populate($data);
    }

   

}