<?php

class User_Form_AddGame extends Kdecom_Form_Base {

    public function init() {
        
        //$this->setAction(APPLICATION_URL."/employer/index/update-my-account");
        $this->setName('EmployerEditAccount');
        $this->_createFormElements();
    }

    private function _createFormElements() {
        $this->createElement('hidden', 'item_id');
        $this->createElement('hidden', 'type')
                ->setValue('1');
        // 1 :- game
        // 2:- Music / DVD
        $this->createElement('text', 'name', "Name");
        $this->createElement('textarea', 'description', "Description")
                ->setAttribs(array('cols'=> "50", "rows"=>"5"));

        $this->createElement('file', 'image1', "Images");
        $this->createElement('file', 'image2', "Images");
        $this->createElement('file', 'image3', "Images");
        $this->createElement('file', 'image4', "Images");
        $this->createElement('file', 'image5', "Images");



        $this->createElement('submit', 'submit', "Update");
        $this->createElement('button', 'cancel', "Cancel");

        $this->addDisplayGroup(array(
            $this->item_id,
            $this->type,
            $this->name,
            $this->description,
            $this->image1,
            $this->image2,
            $this->image3,
            $this->image4,
            $this->image5,
                ), "AddGameData");
        $this->addDisplayGroup(array(
            $this->submit,
            $this->cancel
                ), "Buttons");
    }

    public function populate($data) {
        parent::populate($data);
    }

}