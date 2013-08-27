<?php

class Application_Model_Table_Timesheet extends Kdecom_Tests_Model {

    public $_name = 'timesheet';

    public function testValidSave() {
        
        $model = new Application_Model_Table_Timesheet();
        $model->save();
        $this->assertTrue();
    }

}

