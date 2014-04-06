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

class ContactTypeTable extends AbstractTableGateway {

    protected $table = 'contact_type';

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
    
   
    public function getContactType($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $rowObj = new Entity\ContactType();
        $rowObj->setId($row->id);
        $rowObj->setContactTypeName($row->contact_type_name);
        
        return $rowObj;
    }
  

    public function save(Entity\ContactType $entity) {
        $data = array(
            'contact_type_name' => $entity->getContactTypeName()
        );

        $id = (int) $entity->getId();

        if ($id == 0) {
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getContactType($id)) {
            
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