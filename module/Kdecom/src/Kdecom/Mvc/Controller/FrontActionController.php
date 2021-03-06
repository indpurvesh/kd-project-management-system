<?php

namespace Kdecom\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\Storage\Session,	
    Zend\View\Model\ViewModel;

/**
 * Basic action controller
 */
class FrontActionController extends AbstractActionController {

    public $paginationFilter;
    public $itemsPerPage;
    public $timesheetTable;
    public $coreSystemSettingsTable;
    public $userTable;
    public $assignRoleActionTable;
    public $roleTable;

    
  
    public function isUserLoggedIn() {
        
        
        date_default_timezone_set('Pacific/Auckland');
      
        $this->itemsPerPage = 10;
        $authService = $this->serviceLocator->get('auth_service');
        if ($authService->hasIdentity()) {
            return true;
        }
        $this->redirect()->toRoute('login');
    }

    
    public function nolayout() {
        // Turn off the layout, i.e. only render the view script.
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    /*
     * Upload File 
     * 
     */
    public function upload($file,$path = "/") {
        
        $adapter = new \Zend\File\Transfer\Adapter\Http(); 
        $adapter->setDestination('media' . $path);
        $adapter->receive($file['name']);
        $tmpfilePath = str_replace("media/", "", $adapter->getFileName());
        
        
        
        return str_replace("\\", "/", $tmpfilePath);
    }

    /*
     * 
     * @todo $gridKey and make it work automatically.
     */

    public function setUpPaginationFilter($paginationKey, $gridKeys) {
        $this->paginationFilter = new Session('pagination_storage');

        $filterData = $this->paginationFilter->read();

        if (isset($filterData[$paginationKey])) {

            foreach ($gridKeys as $key => $gridKey) {
                if (isset($filterData[$paginationKey][$gridKey . "-order"])) {
                    if ($filterData[$paginationKey][$gridKey . "-order"] == "ASC") {
                        $filterData[$paginationKey][$gridKey . "-order"] = "DESC";
                    } else {
                        $filterData[$paginationKey][$gridKey . "-order"] = "ASC";
                    }
                } else {
                    $filterData[$paginationKey][$gridKey . "-order"] = "ASC";
                }
            }
        } else {
            foreach ($gridKeys as $key => $gridKey) {
                $filterData[$paginationKey][$gridKey . "-order"] = "ASC";
            }
        }

        $this->paginationFilter->write($filterData);
    }
    
    public function getTimesheetTable() {
    	if (!$this->timesheetTable) {
    		$sm = $this->getServiceLocator();
    		$this->timesheetTable = $sm->get('Application\Model\TimesheetTable');
    	}
    
    	return $this->timesheetTable;
    }
    
    public function getUserTable() {
    	if (!$this->userTable) {
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('Auth\Model\UserTable');
    	}
    
    	return $this->userTable;
    }
    public function getCoreSystemSettingsTable() {
    	if (!$this->coreSystemSettingsTable) {
    		$sm = $this->getServiceLocator();
    		$this->coreSystemSettingsTable = $sm->get('Admin\Model\CoreSystemSettingsTable');
    	}
    	return $this->coreSystemSettingsTable;
    }
    public function getAssignRoleActionTable() {
    	if (!$this->assignRoleActionTable) {
    		$sm = $this->getServiceLocator();
    		$this->assignRoleActionTable = $sm->get('Admin\Model\AssignRoleActionTable');
    	}
    	return $this->assignRoleActionTable
    	;
    }
    public function getRoleTable() {
    	if (is_null($this->roleTable)) {
    		$sm = $this->getServiceLocator();
    		$this->roleTable = $sm->get('Admin\Model\RoleTable');
    	}
    	return $this->roleTable;
    	;
    }
}
