<?php

namespace Auth\Model;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Sql\Select;


use Zend\Db\TableGateway\AbstractTableGateway;

class UserTable  extends AbstractTableGateway{

    protected $tableGateway  = "users";

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function fetchLastUser($limit) {
        $select = new Select();
        $select->from('users')
                ->order('id DESC')
                ->limit($limit);
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    public function getLastInsertUserId() {
        return $this->tableGateway->getLastInsertValue();
    }

    public function getUser($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }



    public function saveUser(User $user) {
        $data = array(
            'user_name' => $user->user_name,
            'user_password' => $user->user_password
        );

        $id = (int) $user->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteUser($id) {
        $this->tableGateway->delete(array('id' => $id));
    }

}
