<?php

namespace Auth\Model\Entity;

class User {

    protected $_id;
    protected $_user_name;
    protected $_first_name;
    protected $_last_name;
    protected $_role_id;
    protected $_email;
    protected $_image;
    protected $_user_password;

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

    public function getUserName() {
        return $this->_user_name;
    }

    public function setUserName($userName) {
        $this->_user_name = $userName;
        return $this;
    }
    public function getUserPassword() {
        return $this->_user_password;
    }

    public function setUserPassword($value) {
        $this->_user_password = $value;
        return $this;
    }

    public function getFirstName() {
        return $this->_first_name;
    }

    public function setFirstName($firstName) {
        $this->_first_name = $firstName;
        return $this;
    }

    public function getLastName() {
        return $this->_last_name;
    }

    public function setLastName($lastName) {
        $this->_last_name = $lastName;
        return $this;
    }

    public function setRoleId($roleId) {
        $this->_role_id = $roleId;
        return $this;
    }

    public function getRoleId() {
        return $this->_role_id;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setEmail($email) {
        $this->_email = $email;
        return $this;
    }

    public function getImage() {
        return $this->_image;
    }

    public function setImage($value) {
        $this->_image = $value;
        return $this;
    }

    public function toArray() {
        $data = array(
            'id' => $this->getId(),
            'user_name' => $this->getUserName(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'role_id' => $this->getRoleId(),
            'email' => $this->getEmail(),
            'image' => $this->getImage(),
            'password' => $this->getPassword()
        );
        return $data;
    }

}