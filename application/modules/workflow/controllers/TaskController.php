<?php

class Workflow_TaskController extends Kdecom_Controller_Action {

    public function indexAction() {

        $model = new Application_Model_Table_Task();
        $result = $model->fetchAll();


        $page = $this->_getParam('page', 1);


        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
    }

    public function editAction() {
        $model = new Application_Model_Table_Task();
        $this->view->form = new Workflow_Form_TaskEdit();

        $id = $this->_getParam('id', NULL);
        if ($id === null || $id == "") {
            $this->view->title = "New Task";
        } else {
            $this->view->title = "Edit Task";
            $taskData = $model->fetchRow('id = ' . intval($id));
            $this->view->form->populate($taskData->toArray());
        }

        
        if ($this->getRequest()->isPost() && $this->view->form->isValid($this->getRequest()->getPost())) {
            $data = $this->getRequest()->getPost();
            
            unset($data['project_name']);
            $id = $this->getRequest()->getParam('id', null);
            unset($data['submit']);
            //$attributePostData = $data['attribute'];
            //unset($data['attribute']);
            
            $data['task_due_date_time'] = date('Y-m-d H:m:s',strtotime($data['task_due_date_time']));
            $data['task_start_date_time'] = date('Y-m-d H:m:s',strtotime($data['task_start_date_time']));
            $data['task_end_date_time'] = date('Y-m-d H:m:s',strtotime($data['task_end_date_time']));
            
            if ($id == NULL || $id == "") {
                unset($data['id']);
                try {
                    $id = $model->insert($data);
                    $projectData = $model->fetchRow('id = ' . intval($id));
                    $this->_helper->flashMessenger->addMessage('Task Record Added.');
                    $this->view->messages = $this->_helper->flashMessenger->getMessages();
                    $this->view->messageType = 'Success';
                    $this->view->messageClass = 'et-download';
                } catch (Exception $e) {
                    //$model->getAdapter()->rollBack();
                    //$attributeValueModel->getAdapter()->rollBack();
                    throw new Exception($e->getMessage());
                }
            } else {
                try {
                    //$attributeValueModel->getAdapter()->beginTransaction();
                    
                    $model->update($data, 'id = ' . intval($id));
                    $projectData = $model->fetchRow('id = ' . intval($id));
                    $this->_helper->flashMessenger->addMessage('Task Record Updates.');
                    $this->view->messages = $this->_helper->flashMessenger->getMessages();
                    $this->view->messageType = 'Success';
                    $this->view->messageClass = 'et-download';
                } catch (Exception $e) {
                    //$model->getAdapter()->rollBack();
                    //$attributeValueModel->getAdapter()->rollBack();
                    throw new Exception($e->getMessage());
                }
            }
        }
    }

    public function viewAction() {
   
        $model = new Application_Model_Table_Project();
        $this->view->projectData = $model->getProjectDataFromId($this->getRequest()->getParam('id'));
        $this->view->title = $this->view->projectData['project_name'];
        
    }

}
