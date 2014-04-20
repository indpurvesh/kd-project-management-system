<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Kdecom\Mvc\Controller\FrontActionController;

use Zend\View\Model\ViewModel;
use Application\Model\Entity\Timesheet;

class TimesheetController extends FrontActionController {

    public $timesheetTable;
    public $_userSessionData;
    
  
    
    public function indexAction() {
    	
    	$this->isUserLoggedIn();
    	$authService = $this->serviceLocator->get('auth_service');
    	$this->_userSessionData = $authService->getIdentity();
    
    	
        $this->_userSessionData = $this->serviceLocator->get('auth_service')->getIdentity();
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
                    $entity->setNotes(trim($timesheetRow['notes']));
                    $entity->setTaskDate($taskDate);
                    
                    
                    $startTime = ($taskDate . " " .$timesheetRow['start_time']. ":00");
                    $endTime = ($taskDate . " " .$timesheetRow['end_time']. ":00");
                   
                    $entity->setStartTime(date('Y-m-d H:i:s', strtotime($startTime)));
                    $entity->setEndTime(date('Y-m-d H:i:s', strtotime($endTime)));

                    $model->save($entity);
                }
            }
            if(isset($postData['save_close']) === true) {
                $this->redirect()->toRoute('home');
            } else {
            	$url = $this->getRequest()->getRequestUri();
            	$this->_redirect($url, array('prependBase' => false));
            }
        }

        
        
        if($this->params()->fromQuery('date',null) !== null) {
        	$date = date('Y-m-d',strtotime($this->params()->fromQuery('date')));
        } else {
        	$date = date('Y-m-d');
        }
        
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
    
  

    public function getTimesheetRowAction() {

    	$this->_userSessionData = $this->serviceLocator->get('auth_service')->getIdentity();
    	$userId = $this->_userSessionData['id'];
        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }

        $viewModel = $this->nolayout();
        $viewModel->userId = $userId;
        return $viewModel;
    }

    public function nolayout() {
        // Turn off the layout, i.e. only render the view script.
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }

}
