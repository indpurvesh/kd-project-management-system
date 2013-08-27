<?php

class Workflow_Form_TaskEdit extends Kdecom_Form_Base {

    public function init() {
        //$this->setAction(APPLICATION_URL."/employer/index/update-my-account");
        $this->setName('TaskEditAccount');
        $this->_createFormElements();
        parent::init();
        
    }

    private function _createFormElements() {
        
        $this->createElement('hidden', 'id');
               
        
        
        $this->createElement('text', 'task_name', "Task Name")
                ->setRequired(true)
                ->addValidator('NotEmpty');
        $this->createElement('datetime', 'task_due_date_time', "Task Due Date time");
        $this->createElement('datetime', 'task_start_date_time', "Task Start Date time");
        $this->createElement('datetime', 'task_end_date_time', "Task End Date time");
        $this->createElement('text', 'project_name', "Project");
        $this->createElement('hidden', 'project_id', "Project");

        

        $url = $this->getView()->url()->makeUrl(
                array(
                    'module' => 'workflow' , 
                    'controller' => 'task',
                    'action' => 'index'
                    ),null,true);
        
        
        $this->createElement('submit', 'submit', "Submit");
        $this->createElement('button', 'cancel', "Cancel")
                ->setAttrib("onclick", "location='".$url . "'");

        $this->addDisplayGroup(array(
            $this->task_name,
            $this->task_due_date_time,
            $this->task_start_date_time,
            $this->task_end_date_time,
            $this->project_name,
            $this->project_id
                ), "TaskEdit");
        
        $editGroup = $this->getDisplayGroup('TaskEdit');
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