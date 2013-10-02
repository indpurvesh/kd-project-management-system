<?php

/**
 * Description of Model Description
 *
 * @author Purvesh <ind.purvesh@gmail.com>, <@kdecom>
 */


namespace Admin\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class ProjectTable extends AbstractTableGateway {

    protected $table = 'project';

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

    public function getProject($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $rowObj = new Entity\Project();
        $rowObj->setId($row->id);
        $rowObj->setProjectTypeId($row->project_type_id);
        $rowObj->setName($row->name);
        $rowObj->setDescription($row->description);
        
        return $rowObj;
    }
  

    /*
     * 
     * @todo finished properly
     */
    public function save(Entity\Project $entity) {
        $data = array(
            'name' => $entity->getName(),
            'description' => $entity->getDescription(),
        );

        $id = (int) $entity->getId();

        if ($id == 0) {
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getProject($id)) {
            
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