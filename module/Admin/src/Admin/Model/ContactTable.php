<?php

/**
 * Description of Model Description
 *
 * @author Purvesh <ind.purvesh@gmail.com>, <@kdecom>
 */
// module/Admin/src/Admin/Model/StickyNotesTable.php

namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class ContactTable extends AbstractTableGateway {

    protected $table = 'contact';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function fetchAll(Select $select = null) {
        if (null === $select)
            $select = new Select();
        $select->from($this->table);
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

    public function getContact($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $rowObj = new Entity\Contact();
        $rowObj->setId($row->id);
        $rowObj->setFirstName($row->first_name);
        $rowObj->setLastName($row->last_name);
        $rowObj->setAddress($row->address);
        $rowObj->setContactTypeId($row->contact_type_id);
        
        return $rowObj;
    }
  

    public function save(Entity\Contact $entity) {
        $data = array(
            'first_name' => $entity->getFirstName(),
            'last_name' => $entity->getLastName(),
            'address' => $entity->getAddress(),
            'contact_type_id' => $entity->getContactTypeId()
        );

        $id = (int) $entity->getId();

        if ($id == 0) {
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getContact($id)) {
            
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }

    public function remove($id) {
        return $this->delete(array('id' => (int) $id));
    }
    
   
}