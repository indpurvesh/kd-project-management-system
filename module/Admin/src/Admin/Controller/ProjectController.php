<?php

/**
 * Update Project
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
    Admin\Form\ProjectForm,
    Zend\Db\Sql\Select;

class ProjectController extends FrontActionController {

    protected $_projectTable;
    protected $_userSessionData;

    public function indexAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }
        
        if($this->params('order_by',null) !== null) {
            $gridKeys = array($this->params('order_by',null));
        } else {
            $gridKeys = array('id','name','due_date','priority');
        }
        $this->setUpPaginationFilter($paginationKey = 'project', $gridKeys);
       
        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $select = new Select();
        
        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $project = $this->getProjectTable()->fetchAll($select->order($order_by . ' ' . $order));
        $itemsPerPage = 2;

        $project->current();
        $paginator = new Paginator(new paginatorIterator($project));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);

        return new ViewModel(array(
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'add_title' => 'Project',
                    'controller_name' => 'project',
                    'pagination_filter' => $this->paginationFilter,
                    'paginator' => $paginator,
                    'project' => true,
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
        
        $title = "Project Add";
        $roleAccessObj = null;

        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $id = $this->params('id', null);
        $model = $this->getProjectTable();
        $form = new ProjectForm();

        if($id !== null) {
            $obj = $model->getProject($id);
            $formData = $obj->toArray();
        }
       
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $obj = new \Admin\Model\Entity\Project;
                $obj->setFirstName($request->getPost('first_name'));
                $obj->setLastName($request->getPost('last_name'));
                $obj->setAddress($request->getPost('address'));
                $obj->setId($request->getPost('id'));
                $model->save($obj);
                return $this->redirect()->toRoute('admin/contact');
            }
        }
        if ($id !== null) {

           
            $title = "Project Update";
            $form->populateValues($formData);
            $form->get('submit')->setValue('Update Project');
        }

        return new ViewModel(array(
                    'form' => $form,
                    'title' => $title,
                    'id' => $id,
                    'project' => true,
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

    public function getProjectTable() {
        if (!$this->_projectTable) {
            $sm = $this->getServiceLocator();
            $this->_projectTable = $sm->get('Admin\Model\ProjectTable');
        }
        return $this->_projectTable
        ;
    }
  
  

}