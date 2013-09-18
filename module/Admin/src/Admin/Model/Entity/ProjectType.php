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

class ProjectType {

    protected $_id;
    protected $_name;
    protected $_description;
    protected $_address;
    protected $_contact_type_id;

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
    
    public function getDescription() {
        return $this->_description;
    }
    
    public function setDescription($value) {
          $this->_description = $value;
        return $this;
    }
    
  
    public function toArray() {
        $data = array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
        );
        return $data;
    }



}

?>
