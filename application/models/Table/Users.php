<?php

class Application_Model_Table_Users extends Kdecom_Db_Table_Abstract {

    public $_name = 'users';

    public function auth($data = array()) {

       
        $registry = Zend_Registry::getInstance();
        $auth = Zend_Auth::getInstance();

        $db = $this->_db;

        $authAdapter = new Zend_Auth_Adapter_DbTable($db);
        $authAdapter->setTableName('users')
                ->setIdentityColumn('user_name')
                ->setCredentialColumn('user_password');

        
        $authAdapter->setIdentity($data['user_name']);
        $authAdapter->setCredential(md5($data['user_password']));

        // Perform the authentication query, saving the result
        $result = $auth->authenticate($authAdapter);

        if ($result->isValid()) {
            $auth->getStorage()->write($data);
            
            return true;
            
        } else {
           return false;
            
        }
    }


}

