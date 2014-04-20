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
// use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\PublicKey\Rsa\PublicKey;

class IndexController extends FrontActionController {
	
	public $_userSessionData;
	
	
	public function indexAction() {
		$this->isUserLoggedIn ();
		
		$authService = $this->serviceLocator->get ( 'auth_service' );
		$this->_userSessionData = $authService->getIdentity ();
		return new ViewModel ( array (
				'userSessionData' => $this->_userSessionData 
		) );
	}
}
