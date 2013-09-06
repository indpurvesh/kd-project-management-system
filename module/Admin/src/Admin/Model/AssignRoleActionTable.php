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

class AssignRoleActionTable extends AbstractTableGateway {

    protected $table = 'assign_role_action';

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

    public function getAssignRoleAction($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $rowObj = new Entity\AssignRoleAction();
        $rowObj->setId($row->id);
        $rowObj->setRoleId($row->role_id);
        $rowObj->setRoleAllowedAction($row->role_allowed_action);
        
        return $rowObj;
    }
    public function getRoleAllowedActionByRoleId($id) {
        $row = $this->select(array('role_id' => (int) $id))->current();
        if (!$row)
            return false;

        $rowObj = new Entity\AssignRoleAction();
        $rowObj->setId($row->id);
        $rowObj->setRoleId($row->role_id);
        $rowObj->setRoleAllowedAction($row->role_allowed_action);
        
        return $rowObj;
    }

    public function saveRole(Entity\AssignRoleAction $role) {
        $data = array(
            'role_id' => $role->getRoleId(),
            'role_allowed_action' => $role->getRoleAllowedAction()
        );

        $id = (int) $role->getId();

        if ($id == 0) {
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getAssignRoleAction($id)) {
            
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