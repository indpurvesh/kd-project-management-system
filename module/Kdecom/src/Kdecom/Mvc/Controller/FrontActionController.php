<?php

namespace Kdecom\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\Storage\Session,
    Zend\View\Model\ViewModel;

/**
 * Basic action controller
 */
class FrontActionController extends AbstractActionController {

    public $_paginationFilter;
    public $itemsPerPage;
    public $timesheetTable;

    public function isUserLoggedIn() {
        
        
        date_default_timezone_set('Pacific/Auckland');
        $this->itemsPerPage = 2;
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
        $this->_paginationFilter = new Session('pagination_storage');

        $filterData = $this->_paginationFilter->read();

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

        $this->_paginationFilter->write($filterData);
    }
    
    public function getTimesheetTable() {
    	if (!$this->timesheetTable) {
    		$sm = $this->getServiceLocator();
    		$this->timesheetTable = $sm->get('Application\Model\TimesheetTable');
    	}
    
    	return $this->timesheetTable;
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
