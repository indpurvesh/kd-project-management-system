<?php

class Admin_EmployeeController extends Kdecom_Controller_Admin {

    public function indexAction() {
        $model = new Application_Model_Table_Employee();
        $result = $model->fetchAll();


        $page = $this->_getParam('page', 1);


        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
    }

    public function editAction() {

        $model = new Application_Model_Table_Employee();

        $this->view->form = new Admin_Form_EmployeeEdit();

        $id = $this->_getParam('id', NULL);
        if ($id === null || $id == "") {
            $this->view->title = "New Employee";
        } else {
            $this->view->title = "Edit Employee";
            $employeeData = $model->fetchRow('id = ' . intval($id));
            $this->view->form->populate($employeeData->toArray());
        }



        if ($this->getRequest()->isPost() && $this->view->form->isValid($this->getRequest()->getPost())) {

            $data = $this->getRequest()->getPost();


            $id = $this->getRequest()->getParam('id', null);
            unset($data['submit']);
            $attributePostData = $data['attribute'];
            unset($data['attribute']);



            if ($id == NULL || $id == "") {
                unset($data['id']);
                // Just removed Empty string
                try {
                    //$model->getAdapter()->beginTransaction();
                    $id = $model->insert($data);
                    $employeeData = $model->fetchRow('id = ' . intval($id));
                    $this->_helper->flashMessenger->addMessage('Employee Record Added.');
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
                    $employeeData = $model->fetchRow('id = ' . intval($id));
                    $this->_helper->flashMessenger->addMessage('Employee Record Updates.');
                    $this->view->messages = $this->_helper->flashMessenger->getMessages();
                    $this->view->messageType = 'Success';
                    $this->view->messageClass = 'et-download';
                } catch (Exception $e) {
                    //$model->getAdapter()->rollBack();
                    //$attributeValueModel->getAdapter()->rollBack();
                    throw new Exception($e->getMessage());
                }
            }







            try {
                $attributeValueModel = new Application_Model_Table_EmployeeAttributeValue();

                foreach ($attributePostData as $key => $value) {

                    foreach ($value as $k => $v) {
                        $attrData = array(
                            'attribute_id' => $key,
                            'attribute_value_text' => $v,
                            'unique_key_attribute' => $k,
                            'employee_id' => $id
                        );


                        $existingData = $attributeValueModel->fetchRow("employee_id = {$id} AND unique_key_attribute = '{$k}'");
                        if (count($existingData) >= 1) {
                            // update
                            $attributeValueModel->update($attrData, "id={$existingData->id}");
                        } else {
                            //$attributeValueModel->getAdapter()->beginTransaction();
                            $attributeValueModel->insert($attrData);
                        }
                    }
                }
            } catch (Exception $e) {
                //$attributeValueModel->getAdapter()->rollBack();
                throw new Exception($e->getMessage());
            }


            //$model->getAdapter()->commit();
            //$attributeValueModel->getAdapter()->commit();
        }
    }

}

