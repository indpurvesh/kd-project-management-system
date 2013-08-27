<?php

class Workflow_ProjectController extends Kdecom_Controller_Action {

    public function indexAction() {

        $model = new Application_Model_Table_Project();
        $result = $model->fetchAll();


        $page = $this->_getParam('page', 1);


        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
    }
    

    public function getJsonListAction() {
        
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $q = $this->_getParam('name_startsWith');
        $model = new Application_Model_Table_Project();
        $data = $model->fetchAll("project_name like '%{$q}%'");
        $output['project_list'] =  $data->toArray();
        
        echo json_encode($output);
    }

    public function editAction() {
        $model = new Application_Model_Table_Project();
        $this->view->form = new Workflow_Form_ProjectEdit();

        $id = $this->_getParam('id', NULL);
        if ($id === null || $id == "") {
            $this->view->title = "New Project";
        } else {
            $this->view->title = "Edit Project";
            $projectData = $model->fetchRow('id = ' . intval($id));
            $this->view->form->populate($projectData->toArray());
        }

        if ($this->getRequest()->isPost() && $this->view->form->isValid($this->getRequest()->getPost())) {
            $data = $this->getRequest()->getPost();
            $id = $this->getRequest()->getParam('id', null);
            unset($data['submit']);
            //$attributePostData = $data['attribute'];
            //unset($data['attribute']);
            if ($id == NULL || $id == "") {
                unset($data['id']);
                try {
                    //$model->getAdapter()->beginTransaction();
                    //@todo 
                    //Before inser MAke sure you inser Created Person ID and PRoject Created Date
                    $id = $model->insert($data);
                    $projectData = $model->fetchRow('id = ' . intval($id));
                    $this->_helper->flashMessenger->addMessage('Project Record Added.');
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
                    $this->_helper->flashMessenger->addMessage('Project Record Updates.');
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
