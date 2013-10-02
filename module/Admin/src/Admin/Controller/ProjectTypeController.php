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
    Admin\Form\ProjectTypeForm,
    Admin\Form\StepForm,
    Admin\Model\Entity\ProjectType,
    Admin\Model\Entity\Step,
    Zend\Db\Sql\Select;

class ProjectTypeController extends FrontActionController {

    protected $_projectTypeTable;
    protected $_stepTable;
    protected $_userSessionData;

    public function indexAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }

        if ($this->params('order_by', null) !== null) {
            $gridKeys = array($this->params('order_by', null));
        } else {
            $gridKeys = array('id', 'name', 'description');
        }
        $this->setUpPaginationFilter($paginationKey = 'project_type', $gridKeys);

        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $role = $this->getProjectTypeTable()->fetchAll($select->order($order_by . ' ' . $order));

        $role->current();
        $paginator = new Paginator(new paginatorIterator($role));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($this->itemsPerPage)
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

        $stepModel = $this->getStepTable();
        $step = array();


        $title = "Project Type Add";
        $roleAccessObj = null;

        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();

        $id = $this->params('id', null);
        $model = $this->getProjectTypeTable();
        $form = new ProjectTypeForm();


        $stepForm = new StepForm();


        $options = $stepModel->getStepOptionByProjectTypeId($id);
        $stepForm->get('parent_step_select')->setAttribute('options', $options);

        $stepForm->get('project_type_id')->setValue($id);

        $step = $stepModel->getRootByProjectTypeId($id);




        if ($id !== null) {
            $obj = $model->getProjectType($id);
            $formData = $obj->toArray();
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $obj = new ProjectType();
                if ($request->getPost('id', null) !== null) {
                    $obj->setId($request->getPost('id'));
                }
                $obj->setName($request->getPost('name'));
                $obj->setDescription($request->getPost('description'));
                $model->save($obj);
                return $this->redirect()->toRoute('admin/projecttype');
            }
        }
        if ($id !== null) {
            $title = "Project Type Update";
            $form->populateValues($formData);
            $form->get('submit')->setValue('Update Project Type');
        }

        return new ViewModel(array(
                    'form' => $form,
                    'title' => $title,
                    'id' => $id,
                    'projecttype' => true,
                    'stepTable' => $stepModel,
                    'step' => $step,
                    'stepForm' => $stepForm,
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

    public function getProjectTypeTable() {
        if (!$this->_projectTypeTable) {
            $sm = $this->getServiceLocator();
            $this->_projectTypeTable = $sm->get('Admin\Model\ProjectTypeTable');
        }
        return $this->_projectTypeTable
        ;
    }

    public function getStepTable() {
        if (!$this->_stepTable) {
            $sm = $this->getServiceLocator();
            $this->_stepTable = $sm->get('Admin\Model\StepTable');
        }
        return $this->_stepTable
        ;
    }

    public function addStepAction() {
        $viewModel = $this->nolayout();

        $data = $this->params()->fromPost();

        $mptt = new \Kdecom\Mptt();

        $mptt->Mptt($data['project_type_id']);
        
        $mptt->add($data['project_type_id'],$data['parent_step_id'], $data['name']);
        return $viewModel;
    }

}