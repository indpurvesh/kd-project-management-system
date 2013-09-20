<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Kdecom\Mvc\Controller\FrontActionController,
    Application\Model\Entity\Timesheet;
use Zend\View\Model\ViewModel;

class TimesheetController extends FrontActionController {

    public $timesheetTable;
    public $_userSessionData;
    public function indexAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }

        $authService = $this->serviceLocator->get('auth_service');
        $this->_userSessionData = $authService->getIdentity();
        
        $userId = $this->_userSessionData['id'];
        $form = new \Application\Form\TimesheetForm;
        $model = $this->getTimesheetTable();
        
        if ($this->getRequest()->isPost() === true) {
            $postData = $this->params()->fromPost();
            foreach ($postData['timesheet'] as $userId => $timesheetRows) {
                foreach ($timesheetRows as $id => $timesheetRow) {
                    $entity = new Timesheet();
                    if(is_int($id) === true) {
                        $entity->setId($id);
                    } 
                    $taskDate = date('Y-m-d', strtotime($postData['task_date']));
                    $entity->setUserId($userId);
                    $entity->setNotes($timesheetRow['notes']);
                    $entity->setTaskDate($taskDate);
                    $entity->setStartTime($taskDate ." " . $timesheetRow['start_time'] . ":00");
                    $entity->setEndTime($taskDate ." " . $timesheetRow['end_time'] . ":00");

                    $model->save($entity);
                }
            }
            if(isset($postData['save_close']) === true) {
                $this->redirect()->toRoute('home');
            } else {
                $this->redirect()->refresh();
            }
        }

        $date = date('d-m-Y');
        
        $timesheetRows = $model->getTimesheetByDateAndByUserId(date('Y-m-d',strtotime($date)) , $userId);
        
        $random = str_shuffle('abcdefghijklmnopqrstuvwxyz');
        
        
        return new ViewModel(array(
                    'form' => $form,
                    'title' => 'Timesheet',
                    'random' => $random,
                    'timesheetRows' => $timesheetRows,
                    'date' => $date,
                    'userSessionData' => $this->_userSessionData
                ));
    }
    
    public function getTimesheetTable() {
        if (!$this->timesheetTable) {
            $sm = $this->getServiceLocator();
            $this->timesheetTable = $sm->get('Application\Model\TimesheetTable');
        }

        return $this->timesheetTable;
    }

    public function getTimesheetRowAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }

        $viewModel = $this->nolayout();

        return $viewModel;
    }

    public function nolayout() {
        // Turn off the layout, i.e. only render the view script.
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }

}
