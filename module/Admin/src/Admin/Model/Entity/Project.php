<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author Purvesh <ind.purvesh@gmail.com>, <@kdecom>
 */
// module/Admin/src/Admin/Model/Entity/StickyNotes.php

namespace Admin\Model\Entity;

class Project {

    protected $_id;
    protected $_project_type_id;
    protected $_name;
    protected $_description;
    protected $_created_date;
    protected $_priority;
    protected $_created_by_user_id;
    protected $_due_date;
    protected $_start_date;

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

    public function getName() {
        return $this->_name;
    }
    
    public function setName($value) {
          $this->_name = $value;
        return $this;
    }
    
    public function getProjectTypeId() {
        return $this->_project_type_id;
    }
    
    public function setProjectTypeId($value) {
          $this->_project_type_id = $value;
        return $this;
    }
    
    public function getDescription() {
        return $this->_description;
    }
    
    public function setDescription ($value) {
          $this->_description = $value;
        return $this;
    }

    public function setCreatedDate($value) {
        $this->_created_date = $value;
        return $this;
    }
    public function getCreatedDate() {
        return $this->_created_date;
    }
    public function setPriority($value) {
        $this->_priority = $value;
        return $this;
    }
    public function getPriority() {
        return $this->_priority;
    }
    public function setCreatedByUserId($value) {
        $this->_created_by_user_id = $value;
        return $this;
    }
    public function getCreatedByUserId() {
        return $this->_created_by_user_id;
    }
    public function setDueDate($value) {
        $this->_due_date = $value;
        return $this;
    }
    public function getDueDate() {
        return $this->_due_date;
    }
    public function setStartDate($value) {
        $this->_start_date = $value;
        return $this;
    }
    public function getStartDate() {
        return $this->_start_date;
    }
    public function toArray() {
        $data = array(
            'id' => $this->getId(),
            'project_type_id' => $this->getProjectTypeId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'created_date' => $this->getCreatedDate(),
            'priority' => $this->getPriority(),
            'created_by_user_id' => $this->getCreatedByUserId(),
            'due_date' => $this->getDueDate(),
            'start_date' => $this->getStartDate()
        );
        return $data;
    }



}

?>
