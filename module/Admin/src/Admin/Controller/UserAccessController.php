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
    Admin\Form\RoleAccessForm,
    Admin\Model\Entity\Role,
    Zend\Db\Sql\Select;

class UserAccessController extends FrontActionController {

    protected $_roleTable;
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


        $role = $this->getRoleTable()->fetchAll($select->order($order_by . ' ' . $order));
        $itemsPerPage = 5;

        $role->current();
        $paginator = new Paginator(new paginatorIterator($role));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);

        return new ViewModel(array(
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'add_title' => 'User Access',
                    'controller_name' => 'user-access',
                    'paginator' => $paginator,
                    'user_access' => true,
                    'userSessionData' => $this->_userSessionData
                ));
    }

    public function updateAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }

        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $id = $this->params('id', null);
        $model = $this->getRoleTable();
        $form = new RoleAccessForm();

        $roleOptions = $model->getRoleOptions();
        $form->get('role_name')->setAttribute('options', $roleOptions);


        if ($id === null) {
            $obj = new Role();
        } else {
            $obj = $model->getRole($id);
            $userData = $obj->toArray();
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $obj->setRoleName($request->getPost('role_name'));
                $model->saveRole($obj);
                return $this->redirect()->toRoute('admin/role');
            }
        }
        if ($id !== null) {

            $form->populateValues($userData);
            $form->get('submit')->setValue('Update Role');
        }

        return new ViewModel(array(
                    'form' => $form,
                    'id' => $id,
                    'user_access' => true,
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

    public function getRoleTable() {
        if (!$this->_roleTable) {
            $sm = $this->getServiceLocator();
            $this->_roleTable = $sm->get('Admin\Model\RoleTable');
        }
        return $this->_roleTable
        ;
    }

    public function getRoleAccessHtmlAction() {
        $viewModel = $this->nolayout();
        
        
        
        return $viewModel;
    }

    public function nolayout() {
        // Turn off the layout, i.e. only render the view script.
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }

}