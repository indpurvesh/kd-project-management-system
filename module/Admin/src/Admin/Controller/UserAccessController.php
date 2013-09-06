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
use Zend\Authentication\Storage\Session;
use Zend\View\Model\ViewModel,
    Admin\Form\RoleAccessForm,
    Admin\Model\Entity\AssignRoleAction,
    Zend\Db\Sql\Select;

class UserAccessController extends FrontActionController {

    protected $_roleTable;
    protected $_assignRoleActionTable;
    protected $_userSessionData;
    protected $_paginationFilter;

    public function indexAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }
        
        $this->_paginationFilter = new Session('pagination_storage');

        $this->_paginationFilter->write(array('user_access' => array('id-order' => 'DESC','role-name-order' => 'ASC')));
        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();


        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;


        $role = $this->getRoleTable()->fetchAll($select->order($order_by . ' ' . $order));
        $itemsPerPage = 2;

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
                    'pagination_filter' => $this->_paginationFilter,
                    'paginator' => $paginator,
                    'user_access' => true,
                    'userSessionData' => $this->_userSessionData
                ));
    }

    public function updateAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }
        
        $roleAccessObj = null;

        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $id = $this->params('id', null);
        $roleModel = $this->getRoleTable();
        $model = $this->getAssignRoleActionTable();
        $form = new RoleAccessForm();

        $roleOptions = $roleModel->getRoleOptions();
        $form->get('role_id')->setAttribute('options', $roleOptions);

        $obj = new AssignRoleAction();

        if ($id !== null) {
       
           
            $roleAccessObj = $this->getAssignRoleActionTable()->getRoleAllowedActionByRoleId($id);
           
         
            $access = json_decode($roleAccessObj->getRoleAllowedAction());
            $formData = $roleAccessObj->toArray();
        }
        

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $obj->setRoleId($request->getPost('role_id'));
                $obj->setId($request->getPost('id'));
                $obj->setRoleAllowedAction(json_encode($request->getPost('access')));
                $model->saveRole($obj);
                return $this->redirect()->toRoute('admin/useraccess');
            }
        }
        if ($id !== null) {

            $form->get('role_id')->setValue($id);
            $form->populateValues($formData);
            $form->get('submit')->setValue('Update Role');
        }

        return new ViewModel(array(
                    'form' => $form,
                    'id' => $id,
                    'user_access' => true,
                    'access_json' => $access,
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
    public function getAssignRoleActionTable() {
        if (!$this->_assignRoleActionTable) {
            $sm = $this->getServiceLocator();
            $this->_assignRoleActionTable = $sm->get('Admin\Model\AssignRoleActionTable');
        }
        return $this->_assignRoleActionTable
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