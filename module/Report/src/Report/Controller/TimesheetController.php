<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Report\Controller;

use Kdecom\Mvc\Controller\FrontActionController;
use Report\Form\HoursByEmployeeForm;
// use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\ContactTable;

class TimesheetController extends FrontActionController {
	private $_contactTable;
	public function hoursByEmployeeAction() {
		if ($this->isUserLoggedIn () === false) {
			$this->redirect ()->toRoute ( 'login' );
		}
		$timesheetRows = null;
		$startDate = null;
		$endDate = null;
		
		$this->_userSessionData = $this->serviceLocator->get('auth_service')->getIdentity();
		$userId = $this->_userSessionData['id'];
		
		
		$form = new HoursByEmployeeForm ();
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {

			$employee = $this->params()->fromPost('employee');
			
			$startDate = date('Y-m-d 00:00:00', strtotime($this->params()->fromPost('from_date')));
			$endDate = date('Y-m-d 00:00:00',  strtotime($this->params()->fromPost('to_date')));
			
			$timesheetModal = $model = $this->getTimesheetTable ();
			$timesheetRows = $timesheetModal->getHoursByEmployeeReport($employee,$startDate,$endDate);
			
			
		}
		$contactModel = $this->getEmployeeModal ();
		$contactOptions = $contactModel->getContactOptions ();
		$form->get ( 'employee' )->setValueOptions ( $contactOptions );
		
		$groupByOptions = array (
				'1' => 'Daily',
				'2' => 'Weekly',
				'3' => 'Monthly' 
		);
		$form->get ( 'group_by' )->setValueOptions ( $groupByOptions );
		
		return new ViewModel ( array (
				'form' => $form ,
				'timesheetRows' => $timesheetRows,
				
				'startDate' => $startDate,
				'endDate' => $endDate
		) );
	}
	private function getEmployeeModal() {
		if (! $this->_contactTable) {
			$sm = $this->getServiceLocator ();
			$this->_contactTable = $sm->get ( 'Admin\Model\ContactTable' );
		}
		
		return $this->_contactTable;
	}
}
