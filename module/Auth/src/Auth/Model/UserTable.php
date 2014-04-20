<?php

namespace Auth\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class UserTable extends AbstractTableGateway {

    protected $table = 'users';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }
    
    public function getUserOptions() {
    	$userOptions = array('' => 'Please Select Any');
    	$users = $this->fetchAll();
    	 
    	 
    	foreach ($users as $user) {
    	
    		$userOptions [$user->id] = $user->first_name . " " . $user->last_name;
    	}
    	return $userOptions;
    }

    public function fetchAll(Select $select = null) {
        if (null === $select)
            $select = new Select();
        $select->from($this->table);
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

    public function getUser($userId) {
        $row = $this->select(array('id' => (int) $userId))->current();
        if (!$row)
            return false;

        $user = new Entity\User();
        $user->setId($row->id);
        $user->setUserName($row->user_name);
        $user->setRoleId($row->role_id);
        $user->setFirstName($row->first_name);
        $user->setLastName($row->last_name);
        $user->setEmail($row->email);
        $user->setImage($row->image);
        $user->setUserPassword($row->user_password);

        return $user;
    }

    public function saveUser(Entity\User $user) {
        $data = array(
            'user_name' => $user->getUserName(),
            'role_id' => $user->getRoleId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'image' => $user->getImage(),
            'user_password' => $user->getUserPassword()
        );

        $id = (int) $user->getId();

        if ($id == 0) {
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getUser($id)) {

            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }

    public function removeUser($id) {
        return $this->delete(array('id' => (int) $id));
    }

}