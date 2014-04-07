<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class TimesheetTable extends AbstractTableGateway {

    protected $table = 'timesheet';

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

    
    public function getTimesheet($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $entityModel = new Entity\Timesheet();
        $entityModel->setId($row->id);
        $entityModel->setUserId($row->user_id);
        $entityModel->setNotes($row->notes);
        $entityModel->setTaskDate($row->task_date);
        $entityModel->setStartTime($row->start_time);
        $entityModel->setEndTime($row->end_time);

        return $entityModel;
    }
    
    public function getHoursByEmployeeReport($userId , $startDate , $endDate) {
    	$select = new Select();
    	$select->from($this->table);
    	$select->where("user_id = ". intval($userId));
    	$select->where("start_time > '" . $startDate . "'");
    	$select->where("end_time < '" . $endDate . "'");
    	$select->order('start_time');
    	
    	$resultSet = $this->selectWith($select);
    	$resultSet->buffer();
    	return $resultSet;
    }
    
    public function getTimesheetByDateAndByUserId($date,$userId) {
        $select = new Select();
        $select->from($this->table);
        $select->where(array('task_date' => $date,'user_id' => $userId));
        $select->order('start_time');
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

    public function save(Entity\Timesheet $entityModel) {
        $data = array(
            'user_id' => $entityModel->getUserId(),
            'notes' => $entityModel->getNotes(),
            'task_date' => $entityModel->getTaskDate(),
            'start_time' => $entityModel->getStartTime(),
            'end_time' => $entityModel->getEndTime()
        );

        $id = (int) $entityModel->getId();

        if ($id == 0) {
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getTimesheet($id)) {

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