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
    Admin\Model\Entity\AssignRoleAction,
    Zend\Db\Sql\Select;

class UserAccessController extends FrontActionController {

    protected $_userSessionData;

    public function indexAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }
        
        if($this->params('order_by',null) !== null) {
            $gridKeys = array($this->params('order_by',null));
        } else {
            $gridKeys = array('id','role_name');
        }
        $this->setUpPaginationFilter($paginationKey = 'user_access', $gridKeys);
       
        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $select = new Select();
        
        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
        $role = $this->getRoleTable()->fetchAll($select->order($order_by . ' ' . $order));

        $role->current();
        $paginator = new Paginator(new paginatorIterator($role));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($this->itemsPerPage)
                ->setPageRange(7);

        
        return new ViewModel(array(
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'add_title' => 'User Access',
                    'controller_name' => 'user-access',
                    'pagination_filter' => $this->paginationFilter,
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
        
        $form->get('cancel')->setAttribute('data-url', $this->url()->fromRoute('admin/useraccess'));
        
        $obj = new AssignRoleAction();

        
        if ($id !== null) {
           
            $roleAccessObj = $model->getRoleAllowedActionByRoleId($id);

            
            if($roleAccessObj !== false) {
            	$access = json_decode($roleAccessObj->getRoleAllowedAction());
            	$formData = $roleAccessObj->toArray();
            } else {
            	$access = json_decode('');
            	$formData = array();
            }
        
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

    public function getRoleAccessHtmlAction() {
        $viewModel = $this->nolayout();
        return $viewModel;
    }

   

}