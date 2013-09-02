<?php

/**
 * Description of IndexController
 *
 * @author Purvesh <ind.purvesh@gmail.com>, <@kdecom>
 */
// module/Admin/src/Admin/Controller/IndexController.php:

namespace Admin\Controller;

use Kdecom\Mvc\Controller\FrontActionController;
use Zend\View\Model\ViewModel;

class IndexController extends FrontActionController {

    protected $_coreSystemSettingsTable;

    public function indexAction() {
        if ($this->isUserLoggedIn() === true) {

            $authService = $this->serviceLocator->get('auth_service');

            $userSesstionData = $authService->getIdentity();

            return new ViewModel(array(
                        'coresystemsettings' => $this->getCoreSystemSettingsTable()->fetchAll(),
                        'userSessionData' => $userSesstionData
                    ));
        }
    }

    public function updateAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }

        $id = $this->params('id');
        $model = $this->getCoreSystemSettingsTable();
        $obj = $model->getCoreSystemSettings($id);
        $data = $obj->toArray();

        $form = new \Admin\Form\CoreSystemSettingsForm();
        $form->get('submit')->setAttribute('value', 'Update');
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $obj->setApplicationName($request->getPost('application_name'));
                $model->saveCoreSystemSettings($obj);
                return $this->redirect()->toRoute('system-settings');
            }
        }

        $form->populateValues($data);
        return new ViewModel(array(
                    'form' => $form,
                    'id' => $id
                ));
    }

    public function getCoreSystemSettingsTable() {
        if (!$this->_coreSystemSettingsTable) {
            $sm = $this->getServiceLocator();
            $this->_coreSystemSettingsTable = $sm->get('Admin\Model\CoreSystemSettingsTable');
        }
        return $this->_coreSystemSettingsTable
        ;
    }

}