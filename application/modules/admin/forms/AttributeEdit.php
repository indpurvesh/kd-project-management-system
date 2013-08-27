<?php

class Admin_Form_AttributeEdit extends Kdecom_Form_Base {

    public function init() {
        
        //$this->setAction(APPLICATION_URL."/employer/index/update-my-account");
        $this->setName('AttributeEdit');
        $this->_createFormElements();
    }

    private function _createFormElements() {
        
        $this->createElement('hidden', 'id');
               
        // system settings cannt be able to insert it .....
        $this->createElement('text', 'unique_key_attribute', "Attribute Scope (unique)")
                ->setRequired(true)
                ->addValidator('NotEmpty');
        $this->createElement('text', 'attribute_title', "Attribute Title");
        
        
        $this->createElement('select', 'attribute_type', "Attribute Type")
                ->addMultiOptions(array(
                    '' => 'Select any',
                    '1' => 'Text',
                    '2' => 'Text Area',
                    '3' => 'Date',
                    '4' => 'Checkbox',
                    '5' => 'Radio',
                    '6' => 'Dropdown'
                    ));
        $this->createElement('select', 'attribute_belongs_to', "Attribute Belongs to")
                ->addMultiOptions(array(
                    '' => 'Select any',
                    '1' => 'Employee',
                    '2' => 'Customer',
                    '3' => 'Client',
                    '4' => 'Projects'
                    ));

        

        $url = $this->getView()->url()->makeUrl(
                                        array(
                                            'module' => 'admin' , 
                                            'controller' => 'attribute',
                                            'action' => 'index')
                                        ,null,true);
        $this->createElement('submit', 'submit', "Submit");
        $this->createElement('button', 'cancel', "Cancel")
                ->setAttrib("onclick", "location='".$url . "'");

        $this->addDisplayGroup(array(
            $this->unique_key_attribute,
            $this->attribute_title,
            $this->attribute_type,
            $this->attribute_belongs_to
                ), "AttributeEdit");
        $this->addDisplayGroup(array(
            $this->submit,
            $this->cancel
                ), "Buttons");
    }

    public function populate($data) {
        parent::populate($data);
    }

}