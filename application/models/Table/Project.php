<?php
/*
 * 
 * @author Purvesh Patel
 */
class Application_Model_Table_Project extends Kdecom_Db_Table_Abstract {

    public $_name = 'project';

    public function getProjectDataFromId($projectId) {
        $data = $this->fetchRow('id='.intval($projectId));
        $data = $data->toArray();
        $typeModel = new Application_Model_Table_ProjectType();
        $typeData = $typeModel->fetchRow("id=".intval($data['project_type_id']));
        
        $data['project_type_data'] = $typeData->toArray();
        
        return $data;
         
    }

    

}

