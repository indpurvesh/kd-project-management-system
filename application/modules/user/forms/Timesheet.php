<?php

class User_Form_Timesheet extends Kdecom_Form_Base {

    public function init() {
        parent::init();
        $this->setName('timesheet_row');
        $this->setMethod('post');
    }

    public function createButton() {
        $this->createElement('button', 'save', 'Save');
        $this->addDisplayGroup(array($this->save), 'buttongroup');
    }

    public function createFormElements($key = null) {
        if($key === null) {
            $key = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'),0,8);
        }
        
        $this->createElement('text', 'start_time', "End time")
                ->removeDecorator('label')
                ->setBelongsTo("timesheet_rows[{$key}]")
                ->setRequired(true)
                ->addValidator('NotEmpty');
        
        $this->createElement('text', 'end_time', "End Time")
                ->removeDecorator('label')
                ->setBelongsTo("timesheet_rows[{$key}]")
                ->setRequired(true)
                ->addValidator('NotEmpty');
        
        $this->createElement('text', 'description', "Description")
                ->removeDecorator('label')
                ->setBelongsTo("timesheet_rows[{$key}]")
                ->setRequired(true)
                ->addValidator('NotEmpty');

        $this->addDisplayGroup(
                array(
            $this->start_time,
            $this->end_time,
            $this->description
                ), "FormElemts-{$key}");
        return $key;
    }
    public function populate(array $values) {
        
        foreach($this->getElements() as $ele) {
            $model = new Application_Model_Table_Task();
            $timeSheetRow = $model->fetchRow('id = ' .$values['task_id']);
            
            if($ele->getName() == "start_time") {
                $task_start_date_time = date("H:i",strtotime($timeSheetRow->task_start_date_time));
                $ele->setValue($task_start_date_time);
            }
            if($ele->getName() == "end_time") {
                $task_end_date_time = date("H:i",strtotime($timeSheetRow->task_end_date_time));
                $ele->setValue($task_end_date_time);
            }
            if($ele->getName() == "description") {
                $ele->setValue($timeSheetRow->task_name);
            }
        }
       
        parent::populate($values);
    }

}