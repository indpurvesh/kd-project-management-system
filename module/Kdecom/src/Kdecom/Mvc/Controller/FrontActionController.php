<?php

namespace Kdecom\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Basic action controller
 */
class FrontActionController extends AbstractActionController {

    public function isUserLoggedIn() {
        $authService = $this->serviceLocator->get('auth_service');
        if ($authService->hasIdentity()) {
            return true;
        }
        $this->redirect()->toRoute('login');
    }

}
