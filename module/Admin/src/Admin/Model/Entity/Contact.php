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

class Contact {

    protected $_id;
    protected $_first_name;
    protected $_last_name;
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

    public function getFirstName() {
        return $this->_first_name;
    }
    
    public function setFirstName($value) {
          $this->_first_name = $value;
        return $this;
    }
    
    public function getLastName() {
        return $this->_last_name;
    }
    
    public function setLastName($value) {
          $this->_last_name = $value;
        return $this;
    }
    
    public function getAddress() {
        return $this->_address;
    }
    
    public function setAddress($value) {
          $this->_address = $value;
        return $this;
    }

    public function setContactTypeId($value) {
        $this->_contact_type_id = $value;
        return $this;
    }
    public function getContactTypeId() {
        return $this->_contact_type_id;
    }
    public function toArray() {
        $data = array(
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'address' => $this->getAddress(),
            'contact_type_id' => $this->getContactTypeId(),
        );
        return $data;
    }



}

?>
