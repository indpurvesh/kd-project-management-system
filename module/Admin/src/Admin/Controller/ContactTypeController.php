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
    Admin\Form\ContactTypeForm,
    Zend\Db\Sql\Select;

class ContactTypeController extends FrontActionController {

    protected $_contactTypeTable;
    protected $_userSessionData;

    public function indexAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }
        
        if($this->params('order_by',null) !== null) {
            $gridKeys = array($this->params('order_by',null));
        } else {
            $gridKeys = array('id','contact_type_name');
        }
        $this->setUpPaginationFilter($paginationKey = 'contact_type', $gridKeys);
       
        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $select = new Select();
        
        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $role = $this->getContactTypeTable()->fetchAll($select->order($order_by . ' ' . $order));
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
                    'add_title' => 'Contact Type',
                    'controller_name' => 'contact-type',
                    'pagination_filter' => $this->_paginationFilter,
                    'paginator' => $paginator,
                    'contact_type' => true,
                    'userSessionData' => $this->_userSessionData
                ));
    }

    public function updateAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }
        
        $title = "Contact Type Add";
        $roleAccessObj = null;

        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $id = $this->params('id', null);
        $model = $this->getContactTypeTable();
        $form = new ContactTypeForm();

        if($id !== null) {
            $obj = $model->getContactType($id);
            $formData = $obj->toArray();
        }
       
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $obj = new \Admin\Model\Entity\ContactType;
                $obj->setContactTypeName($request->getPost('contact_type_name'));
                $obj->setId($request->getPost('id'));
                $model->save($obj);
                return $this->redirect()->toRoute('admin/contacttype');
            }
        }
        if ($id !== null) {

           
            $title = "Contact Type Update";
            $form->populateValues($formData);
            $form->get('submit')->setValue('Update Role');
        }

        return new ViewModel(array(
                    'form' => $form,
                    'title' => $title,
                    'id' => $id,
                    'contact_type' => true,
                    'userSessionData' => $this->_userSessionData
                ));
    }

    public function deleteAction() {
        $id = $this->params('id', null);
        if ($id === null) {
            throw new Exception('ID is missing');
        }

        $model = $this->getContactTypeTable();
        $model->remove($id);
        $this->redirect()->toRoute('admin/contacttype');
    }

    public function getContactTypeTable() {
        if (!$this->_contactTypeTable) {
            $sm = $this->getServiceLocator();
            $this->_contactTypeTable = $sm->get('Admin\Model\ContactTypeTable');
        }
        return $this->_contactTypeTable
        ;
    }
  
  

}