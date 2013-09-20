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
use Kdecom\Mptt;

class StepTable extends AbstractTableGateway {

    protected $table = 'step';
    public $returnStep;

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

    public function getStep($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $rowObj = new Entity\Step();
        $rowObj->setId($row->id);
        $rowObj->setName($row->name);
        $rowObj->setDescription($row->description);
        $rowObj->setProjectTypeId($row->project_type_id);

        return $rowObj;
    }

    public function getStepsTreeByProjectTypeId($id = null) {


        $mptt = new Mptt();
        $mptt->Mptt($id);

        $step = $mptt->get_tree();
        return $step;
    }

    public function getStepOptionByProjectTypeId($id) {

        $options = array('' => 'Please Select Any');
        $rows = $this->fetchAll();
        foreach ($rows as $row) {
            $options [$row->id] = $row->name;
        }
        return $options;
    }

    public function save(Entity\ProjectType $entity) {
        $data = array(
            'name' => $entity->getName(),
            'description' => $entity->getDescription(),
            'project_type_id' => $entity->getProjectTypeId(),
        );

        $id = (int) $entity->getId();

        if ($id == 0) {
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getStep($id)) {

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

    public function isChildExist($id) {

        $select = new Select();
        $select->from($this->table);
        $select->where(array('parent_step_id' => (int) $id));
        $resultSet = $this->selectWith($select);

        if (count($resultSet->buffer()) > 0) {
            return true;
        }

        return false;
    }

    public function getChild($id) {

        $select = new Select();
        $select->from($this->table);
        $select->where(array('parent_step_id' => (int) $id));
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();

        return $resultSet;
    }

}