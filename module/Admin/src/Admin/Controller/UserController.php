<?php

/**
 * Update User Details and Remove Users and etc
 *
 * @author Purvesh <ind.purvesh@gmail.com>, <@kdecom>
 */
// module/Admin/src/Admin/Controller/UserController.php:

namespace Admin\Controller;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Kdecom\Mvc\Controller\FrontActionController;
use Zend\View\Model\ViewModel,
    Admin\Form\UserForm,
    Auth\Model\Entity\User,
    Zend\Db\Sql\Select;

class UserController extends FrontActionController {

    protected $_usersTable;
    protected $_userSessionData;

    public function indexAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }
        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;


        $users = $this->getUserTable()->fetchAll($select->order($order_by . ' ' . $order));
        $itemsPerPage = 5;

        $users->current();
        $paginator = new Paginator(new paginatorIterator($users));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);

        return new ViewModel(array(
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'add_title' => "User",
                    'controller_name' => "user",
                    'user' => true,
                    'paginator' => $paginator,
                    'userSessionData' => $this->_userSessionData
                ));
    }

    public function updateAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }


        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $id = $this->params('id');
        $model = $this->getUserTable();
        $form = new UserForm();

        if ($id === null) {
            $obj = new User();
        } else {
            $obj = $model->getUser($id);
            $userData = $obj->toArray();
        }


        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $obj->setEmail($request->getPost('email'));
                $obj->setFirstName($request->getPost('first_name'));
                $obj->setLastName($request->getPost('last_name'));
                $model->saveUser($obj);
                return $this->redirect()->toRoute('admin/user');
            }
        }

        if ($id !== null) {
            $form->populateValues($userData);
        }

        return new ViewModel(array(
                    'form' => $form,
                    'id' => $id,
                    'user' => true,
                    'userSessionData' => $this->_userSessionData
                ));
    }

    public function deleteAction() {
        $id = $this->params('id', null);
        if ($id === null) {
            throw new Exception('ID is missing');
        }

        $model = $this->getUserTable();
        $model->removeUser($id);
        $this->redirect()->toRoute('admin/user');
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