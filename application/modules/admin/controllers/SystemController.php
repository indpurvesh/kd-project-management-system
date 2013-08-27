<?php

class Admin_SystemController extends Kdecom_Controller_Admin {

    public function indexAction() {


        $model = new Application_Model_Table_CoreSystemSettings();
        $systemData = $model->fetchRow('id = 1');
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $id = $this->getRequest()->getParam('id',null);
            
            
            unset($data['submit']);
            if ($model->update($data,'id = '. intval($id))) {
                // Success Msg Stuff
                $systemData = $model->fetchRow('id = 1');
                $this->_helper->flashMessenger->addMessage('Settings saved');
                $this->view->messages = $this->_helper->flashMessenger->getMessages();
                $this->view->messageType = 'Success';
                $this->view->messageClass = 'et-download';
            } else {
                // Error Msg Stuff
                $this->_helper->flashMessenger->addMessage('Settings did not saved. try again later');
                $this->view->messages = $this->_helper->flashMessenger->getMessages();
                $this->view->messageType = 'Warning';
                $this->view->messageClass = 'et-warning';
            }
        }
        
        $this->view->form = new Admin_Form_SystemSettings();
        $this->view->form->populate($systemData->toArray());
    }

}

