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

class AssignRoleAction {

    protected $_id;
    protected $_role_id;
    protected $_role_allowed_action;

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

    public function getRoleId() {
        return $this->_role_id;
    }

    public function setRoleId($roleId) {
        $this->_role_id = $roleId;
        return $this;
    }
    public function getRoleAllowedAction() {
        return $this->_role_allowed_action;
    }

    public function setRoleAllowedAction($roleAllowedAction) {
        $this->_role_allowed_action = $roleAllowedAction;
        return $this;
    }
    
    public function toArray() {
        $data = array(
            'id' => $this->getId(),
            'role_id' => $this->getRoleId(),
            'role_allowed_action' => $this->getRoleAllowedAction()
        );
        return $data;
    }



}

?>
