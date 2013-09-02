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

    public function getUser($userId) {
        $row = $this->select(array('id' => (int) $userId))->current();
        if (!$row)
            return false;

        $user = new Entity\User();
        $user->setId($row->id);
        $user->setUserName($row->user_name);
        $user->setFirstName($row->first_name);
        $user->setLastName($row->last_name);
        $user->setEmail($row->email);

        return $user;
    }

    public function saveUser(Entity\User $user) {
        $data = array(
            'email' => $user->getEmail(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName()
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

}