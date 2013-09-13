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

class TimesheetController extends FrontActionController {

    public function indexAction() {

        if ($this->isUserLoggedIn() === false) {
            $this->redirect()->toRoute('login');
        }

        $form = new \Application\Form\TimesheetForm;
        //$model = new 
        
        if ($this->getRequest()->isPost() === true) {
            var_dump($this->params()->fromPost());
            die;
        }

        $date = date('d-m-Y');
        $random = str_shuffle('abcdefghijklmnopqrstuvwxyz');
        return new ViewModel(array(
                    'form' => $form,
                    'title' => 'Timesheet',
                    'random' => $random,
                    'date' => $date
                ));
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
