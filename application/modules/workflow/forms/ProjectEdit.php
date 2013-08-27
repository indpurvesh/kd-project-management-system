<?php

class Workflow_Form_ProjectEdit extends Kdecom_Form_Base {

    public function init() {
        //$this->setAction(APPLICATION_URL."/employer/index/update-my-account");
        $this->setName('ProjectEditAccount');
        $this->_createFormElements();
        parent::init();
        
    }

    private function _createFormElements() {
        
        $this->createElement('hidden', 'id');
               
        $projectTypeModel = new Application_Model_Table_ProjectType();
        $projectTypes = $projectTypeModel->fetchAll();
        foreach ($projectTypes as $projectType) {
            $projectTypesArray[$projectType->id] = $projectType->project_type_name;
        }
        
        // system settings cannt be able to insert it .....
        $this->createElement('select', 'project_type_id', "Project Type")
                ->setRequired(true)
                ->setMultiOptions($projectTypesArray)
                ->addValidator('NotEmpty');
        
        $this->createElement('text', 'project_name', "Project Name")
                ->setRequired(true)
                ->addValidator('NotEmpty');
        $this->createElement('text', 'project_description', "Project Description");
        $this->createElement('text', 'priority', "Project PRiority");

        

        $url = $this->getView()->url()->makeUrl(
                array(
                    'module' => 'workflow' , 
                    'controller' => 'project',
                    'action' => 'index'
                    ),null,true);
        
        
        $this->createElement('submit', 'submit', "Submit");
        $this->createElement('button', 'cancel', "Cancel")
                ->setAttrib("onclick", "location='".$url . "'");

        $this->addDisplayGroup(array(
            $this->project_name,
            $this->project_description,
            $this->project_type_id,
            $this->priority
                ), "ProjectEdit");
        
        $editGroup = $this->getDisplayGroup('ProjectEdit');
        //$this->addAttibuteElementToGroup($belongsToId = 4,$editGroup);
        
        $this->addDisplayGroup(array(
            $this->submit,
            $this->cancel
                ), "Buttons");
    }

    public function populate($data) {
        
        
        
        if($data['id'] != "") {
            //$this->assignAttibuteElementToValue($data['id'], $belongsToId = 4);
        }
        parent::populate($data);
    }

   

}