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

class CoreSystemSettings {

    protected $_id;
    protected $_application_name;
    protected $_default_timezone;

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

    public function getApplicationName() {
        return $this->_application_name;
    }

    public function setApplicationName($applicationName) {
        $this->_application_name = $applicationName;
        return $this;
    }

    public function getDefaultTimeZone() {
    	return $this->_default_timezone;
    }
    
    public function setDefaultTimeZone($value) {
    	$this->_default_timezone = $value;
    	return $this;
    }
    public function toArray() {
        $data = array(
            'id' => $this->getId(),
            'application_name' => $this->getApplicationName(),
        	'default_timezone' => $this->getDefaultTimeZone()
             );
        return $data;
    }



}

?>
