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

class RoleTable extends AbstractTableGateway {

    protected $table = 'role';

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

    public function getRole($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $role = new Entity\Role();
        $role->setId($row->id);
        $role->setRoleName($row->role_name);
        
        return $role;
    }

    public function saveRole(Entity\Role $role) {
        $data = array(
            'role_name' => $role->getRoleName()
        );

        $id = (int) $role->getId();

        if ($id == 0) {
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getRole($id)) {
            
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }

    public function removeRole($id) {
        return $this->delete(array('id' => (int) $id));
    }

}