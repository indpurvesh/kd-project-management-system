<?php

/**
 * Update User Details and Remove Users and etc
 *
 * @author Purvesh <ind.purvesh@gmail.com>, <@kdecom>
 */
// module/Admin/src/Admin/Controller/UserController.php:

namespace Admin\Controller;

use Kdecom\Mvc\Controller\FrontActionController;
use Zend\View\Model\ViewModel,
    Admin\Form\UserForm;

class UserController extends FrontActionController {

    protected $_usersTable;

    public function updateAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }

        $id = $this->params('id');
        $model = $this->getUserTable();
        $form = new UserForm();
        
        $obj = $model->getUser($id);
        $userData = $obj->toArray();
       
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $obj->setEmail($request->getPost('email'));
                $obj->setFirstName($request->getPost('first_name'));
                $obj->setLastName($request->getPost('last_name'));
                $model->saveUser($obj);
                return $this->redirect()->toRoute('system-settings');
            }
        }

        $form->populateValues($userData);
        return new ViewModel(array(
                    'form' => $form,
                    'id' => $id
                ));
    }

    public function getUserTable() {
        if (!$this->_usersTable) {
            $sm = $this->getServiceLocator();
            $this->_usersTable = $sm->get('Admin\Model\UserTable');
        }
        return $this->_usersTable
        ;
    }

}