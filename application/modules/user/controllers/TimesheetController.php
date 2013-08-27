<?php

class User_TimesheetController extends Kdecom_Controller_Action {

    /*
     * 
     * @todo Get timesheet task based on date and displayed it propertly
     */
    public function indexAction() {
        
        $this->view->form = Kdecom_Form_Base::factory('User_Form_Timesheet');
        $pDate = $this->getRequest()->getParam('date',null);
        if($pDate !== null) {
            $pDate = date_create($pDate);
            $this->view->date = date_format($pDate , 'd-m-Y');
            $date = date_format($pDate, 'Y-m-d');
        } else {
            
            $this->view->date = date('d-m-Y');
            $date = date('Y-m-d');
        }
        $timesheetModel = new Application_Model_Table_Timesheet();
        
        $where = "task_date = '" . $date . "'";
        $timesheetRows = $timesheetModel->fetchAll($where);
        
        if(count($timesheetRows) > 0) {
            foreach ($timesheetRows as $row) {
                $tmpData  = $row->toArray();
                
                $this->view->form->createFormElements($tmpData['id']);
                $this->view->form->populate($tmpData);
            }
        } else {
            $this->view->form->createFormElements();
        }
        
        
        
        //$this->view->form->createButton();
    }

    public function editAction() {
    }
    
    /*
     * 
     * @todo Update is not working
     */
    public function saveAction() {
        
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $data = $this->getRequest()->getPost();
        $date = $data['date'];
        foreach ($data['timesheet_rows'] as $key => $timesheetRow) {
            
            $taskModel = new Application_Model_Table_Task();
            $timesheetModel = new Application_Model_Table_Timesheet();
            
            
            
            if(is_int($key)) {
                $dataUpdate = true;
                $updateTimesheetRow = $timesheetModel->fetchRow('id='.intval($key));
                $taskId = $updateTimesheetRow->task_id;
                
            } else {
                $dataUpdate = false;
            }
            
            
            
            
            $taskStartDateTime = date('Y-m-d',strtotime($date)) . " ".  $timesheetRow['start_time'] . ":00";
            $taskEndDateTime = date('Y-m-d',strtotime($date)) . " ".  $timesheetRow['end_time'] . ":00";
            
            $taskData = array(
                'task_name' => $timesheetRow['description'],
                'task_start_date_time' => $taskStartDateTime, 
                'task_end_date_time' => $taskEndDateTime 
            );
            try {
                if($dataUpdate) {
                    $taskModel->update($taskData,'id = '.intval($taskId));
            
                } else {
                    
                    $taskId = $taskModel->insert($taskData);
                }
            } catch(Exception $e) {
                $result ['success'] = false;
                throw new Exception($e->getMessage());
                $this->_helper->json($result);
            }
            
            
            $timesheetData = array(
                'task_id' => $taskId,
                'task_date' => date('Y-m-d',strtotime($date)),
            );
            try {
                 if($dataUpdate) {
                    $timesheetModel->update($timesheetData,'id = '.intval($key));
                } else {
                    $timesheetModel->insert($timesheetData);
                }
            } catch(Exception $e) {
                $result ['success'] = false;
                throw new Exception($e->getMessage());
                $this->_helper->json($result);
            }
        }
        $result ['success'] = true;
        $this->_helper->json($result);
        
    }

    public function addNewRowAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        
        $form = Kdecom_Form_Base::factory('User_Form_Timesheet');
        $key = $form->createFormElements();
        echo $form->getDisplayGroup("FormElemts-{$key}");
    }
    

}

