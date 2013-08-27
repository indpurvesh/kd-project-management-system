<?php

class Application_Model_Table_CoreSystemSettings extends Kdecom_Db_Table_Abstract {

    public $_name = 'core_system_settings';

    public function insert(array $data) {
        throw new Exception ('You are not allowed to insert new record');
    }

}

