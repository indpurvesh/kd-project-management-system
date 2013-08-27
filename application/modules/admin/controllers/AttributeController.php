<?php

class Admin_AttributeController extends Kdecom_Controller_Admin {

    public function indexAction() {
        $model = new Application_Model_Table_Attribute();
        $result = $model->fetchAll();


        $page = $this->_getParam('page', 1);


        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
    }

    public function editAction() {

        $model = new Application_Model_Table_Attribute();

        $this->view->form = new Admin_Form_AttributeEdit();

        $id = $this->_getParam('id', NULL);
        if ($id === null || $id == "") {
            $this->view->title = "New Attribute";
        } else {
            $this->view->title = "Edit Attribute";
            $employeeData = $model->fetchRow('id = ' . intval($id));
            
            //disabled 
            $this->view->form->populate($employeeData->toArray());
        }
        
      

        if ($this->getRequest()->isPost() && $this->view->form->isValid($this->getRequest()->getPost())) {

            $data = $this->getRequest()->getPost();
            $id = $this->getRequest()->getParam('id', null);
            unset($data['submit']);

            if ($id == NULL || $id == "") {
                unset($data['id']);
                // Just removed Empty string
                try {
                    $id = $model->insert($data);
                    $employeeData = $model->fetchRow('id = ' . intval($id));
                    $this->_helper->flashMessenger->addMessage('Attribute Record Added.');
                    $this->view->messages = $this->_helper->flashMessenger->getMessages();
                    $this->view->messageType = 'Success';
                    $this->view->messageClass = 'et-download';
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            } else {
                try {
                    $model->update($data, 'id = '. intval($id));
                    $employeeData = $model->fetchRow('id = ' . intval($id));
                    $this->_helper->flashMessenger->addMessage('Attribute Record Updates.');
                    $this->view->messages = $this->_helper->flashMessenger->getMessages();
                    $this->view->messageType = 'Success';
                    $this->view->messageClass = 'et-download';
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            }
        }
    }

}

