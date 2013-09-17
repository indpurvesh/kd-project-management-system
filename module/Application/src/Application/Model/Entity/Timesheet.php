<?php

namespace Application\Model\Entity;

class Timesheet {

     protected $_id;
    protected $_user_id;
    protected $_notes;
    protected $_task_date;
    protected $_start_time;
    protected $_end_time;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getUserId() {
        return $this->_user_id;
    }

    public function setUserId($value) {
        $this->_user_id = $value;
        return $this;
    }
    public function getNotes() {
        return $this->_notes;
    }

    public function setNotes($value) {
        $this->_notes = $value;
        return $this;
    }
    public function getTaskDate() {
        return $this->_task_date;
    }

    public function setTaskDate($value) {
        $this->_task_date = $value;
        return $this;
    }
    public function getStartTime() {
        return $this->_start_time;
    }

    public function setStartTime($value) {
        $this->_start_time = $value;
        return $this;
    }
    public function getEndTime() {
        return $this->_end_time;
    }

    public function setEndTime($value) {
        $this->_end_time = $value;
        return $this;
    }
    
    public function toArray() {
        $data = array(
            'id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'notes' => $this->getNotes(),
            'task_Date' => $this->getTaskDate(),
            'start_time' => $this->getStartTime(),
            'end_time' => $this->getEndTime()
        );
        return $data;
    }

}