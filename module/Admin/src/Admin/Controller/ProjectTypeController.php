<?php

/**
 * Update Project Type with steps creating as well
 * 
 *
 * @author Purvesh <ind.purvesh@gmail.com>, <@kdecom>
 */
// module/Admin/src/Admin/Controller/UserController.php:

namespace Admin\Controller;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Kdecom\Mvc\Controller\FrontActionController;
use Zend\View\Model\ViewModel,
     Admin\Form\ContactForm,
    Zend\Db\Sql\Select;

class ProjectTypeController extends FrontActionController {

    protected $_projectTable;
    protected $_userSessionData;

    public function indexAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }
        
        if($this->params('order_by',null) !== null) {
            $gridKeys = array($this->params('order_by',null));
        } else {
            $gridKeys = array('id','first_name','last_name');
        }
        $this->setUpPaginationFilter($paginationKey = 'contact', $gridKeys);
       
        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $select = new Select();
        
        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $role = $this->getContactTable()->fetchAll($select->order($order_by . ' ' . $order));
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
                    'add_title' => 'Project Type',
                    'controller_name' => 'project-type',
                    'pagination_filter' => $this->_paginationFilter,
                    'paginator' => $paginator,
                    'projecttype' => true,
                    'userSessionData' => $this->_userSessionData
                ));
    }
    
    /*
     * 
     * @todo If user has login Yes then create login as well with model....
     * 
     */

    public function updateAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }
        
        $title = "Contact Add";
        $roleAccessObj = null;

        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $id = $this->params('id', null);
        $model = $this->getContactTable();
        $form = new ContactForm();

        if($id !== null) {
            $obj = $model->getContact($id);
            $formData = $obj->toArray();
        }
       
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $obj = new \Admin\Model\Entity\Contact;
                $obj->setFirstName($request->getPost('first_name'));
                $obj->setLastName($request->getPost('last_name'));
                $obj->setAddress($request->getPost('address'));
                $obj->setId($request->getPost('id'));
                $model->save($obj);
                return $this->redirect()->toRoute('admin/contact');
            }
        }
        if ($id !== null) {

           
            $title = "Contact Type Update";
            $form->populateValues($formData);
            $form->get('submit')->setValue('Update Contact');
        }

        return new ViewModel(array(
                    'form' => $form,
                    'title' => $title,
                    'id' => $id,
                    'contact' => true,
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

    public function getContactTable() {
        if (!$this->_projectTable) {
            $sm = $this->getServiceLocator();
            $this->_projectTable = $sm->get('Admin\Model\ProjectTypeTable');
        }
        return $this->_projectTable
        ;
    }
  
  

}