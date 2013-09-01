<?php

/**
 * Description of Model Description
 *
 * @author Purvesh <ind.purvesh@gmail.com>, <@kdecom>
 */
// module/Admin/src/Admin/Model/StickyNotesTable.php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class UsersTable extends AbstractTableGateway {

    protected $table = 'users';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

//    public function fetchAll() {
//        $resultSet = $this->select(function (Select $select) {
//                    $select->order('id ASC');
//                });
//        $entities = array();
//        foreach ($resultSet as $row) {
//            $entity = new Entity\CoreSystemSettings();
//            $entity->setId($row->id)
//                    ->setApplicationName($row->application_name);
//            $entities[] = $entity;
//        }
//        return $entities;
//    }
//
//    public function getCoreSystemSettings($id) {
//        $row = $this->select(array('id' => (int) $id))->current();
//        if (!$row)
//            return false;
//
//        $coreSystemSettings = new Entity\CoreSystemSettings();
//        $coreSystemSettings->setId($row->id);
//        $coreSystemSettings->setApplicationName($row->application_name);
//        
//        return $coreSystemSettings;
//    }
//
//    public function saveCoreSystemSettings(Entity\CoreSystemSettings $coreSystemSettings) {
//        $data = array(
//            'application_name' => $coreSystemSettings->getApplicationName()
//        );
//
//        $id = (int) $coreSystemSettings->getId();
//
//        if ($id == 0) {
//            if (!$this->insert($data))
//                return false;
//            return $this->getLastInsertValue();
//        }
//        elseif ($this->getCoreSystemSettings($id)) {
//            
//            if (!$this->update($data, array('id' => $id)))
//                return false;
//            return $id;
//        }
//        else
//            return false;
//    }
//
//    public function removeCoreSystemSettings($id) {
//        return $this->delete(array('id' => (int) $id));
//    }

}