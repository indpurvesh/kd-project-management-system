<?php

class Admin_Form_ProjectTypeEdit extends Kdecom_Form_Base {

    public function init() {
        //$this->setAction(APPLICATION_URL."/employer/index/update-my-account");
        $this->setName('ProjectTypeEditAccount');
        $this->_createFormElements();
        parent::init();
        
    }

    private function _createFormElements() {
        
        $this->createElement('hidden', 'id');
               
        // system settings cannt be able to insert it .....
        $this->createElement('text', 'project_type_name', "Project Type Name")
                ->setRequired(true)
                ->addValidator('NotEmpty');
        $this->createElement('textarea', 'project_type_description', "Project Type Description");

        

        $url = $this->getView()->url()->makeUrl(
                array(
                    'module' => 'admin' , 
                    'controller' => 'project-type',
                    'action' => 'index'
                    ),null,true);
        
        
        $this->createElement('submit', 'submit', "Submit");
        $this->createElement('button', 'cancel', "Cancel")
                ->setAttrib("onclick", "location='".$url . "'");

        $this->addDisplayGroup(array(
            $this->project_type_name,
            $this->project_type_description
                ), "ProjectTypeEdit");
        
        $editGroup = $this->getDisplayGroup('ProjectTypeEdit');
        //$this->addAttibuteElementToGroup($belongsToId = 1,$editGroup);
        
        $this->addDisplayGroup(array(
            $this->submit,
            $this->cancel
                ), "Buttons");
    }

    public function populate($data) {
        
        
        if($data['id'] != "" && $data['id'] >= 1 ) {
            //$this->assignAttibuteElementToValue($data['id'], $belongsToId = 1);
        }
        parent::populate($data);
    }

   

}