<?php

/**
 */

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\Authentication\Adapter\DbTable,
    Zend\Session\Container as SessionContainer,
    Zend\View\Model\ViewModel,
    Auth\Model\Entity\User,
    Auth\Form\Login,
    Auth\Form\Register;

class LoginController extends AbstractActionController {

    
    public function loginAction() {
        
        
        $authService = $this->serviceLocator->get('auth_service');
        if ($authService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        $form = new Login;
        
        
        $loginMsg = array();
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if (!$form->isValid()) {
                // not valid form
                return new ViewModel(array(
                            'title' => 'Log In',
                            'form' => $form
                        ));
            }

            $loginData = $form->getData();
            
            $dbAdapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
            
            
            $authAdapter = new DbTable($dbAdapter, 'users', 'user_name', 'user_password', 'MD5(?)');
            $authAdapter->setIdentity($loginData['username'])
                    ->setCredential(($loginData['password']));
            $authService = $this->serviceLocator->get('auth_service');
            $authService->setAdapter($authAdapter);
            $result = $authService->authenticate();
            if ($result->isValid()) {
                // set id as identifier in session
                $userId = $authAdapter->getResultRowObject('id')->id;
                $userName = $authAdapter->getResultRowObject('user_name')->user_name;
                $firstName = $authAdapter->getResultRowObject('first_name')->first_name;
                $authService->getStorage()->write(array('id' => $userId,'user_name' => $userName,'first_name' => $firstName));
                
              
                return $this->redirect()->toRoute('home');
            } else {
                
                $loginMsg = $result->getMessages();
            }
        }
        

        return new ViewModel(array('title' => 'Log In',
                    'form' => $form,
                    'loginMsg' => $loginMsg
                ));
    }

    public function registerAction() {
        
        
        $authService = $this->serviceLocator->get('auth_service');
        if ($authService->hasIdentity()) {
            // if not log in, redirect to account page or home page..
            //return $this->redirect()->toUrl('/zf/main');
        }

        $form = new Register;
        
        
        $loginMsg = array();
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if (!$form->isValid()) {
                // not valid form
                return new ViewModel(array(
                            'title' => 'Register',
                            'form' => $form
                        ));
            }

            $loginData = $form->getData();
            
            $dbAdapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
            
            
            $authAdapter = new DbTable($dbAdapter, 'user', 'username', 'password', 'MD5(?)');
            $authAdapter->setIdentity($loginData['username'])
                    ->setCredential(($loginData['password']));
            $authService = $this->serviceLocator->get('auth_service');
            $authService->setAdapter($authAdapter);
            $result = $authService->authenticate();
            if ($result->isValid()) {
                // set id as identifier in session
                $userId = $authAdapter->getResultRowObject('id')->id;
                $userName = $authAdapter->getResultRowObject('user_name')->user_name;
                $authService->getStorage()->write($userId);
                $authService->getStorage()->write($userName);
                return $this->redirect()->toRoute('home');
            } else {
                
                $loginMsg = $result->getMessages();
            }
        }
        

        return new ViewModel(array('title' => 'Register',
                    'form' => $form,
                    'loginMsg' => $loginMsg
                ));
    }
    
    public function logoutAction() {
        $authService = $this->serviceLocator->get('auth_service');
        if (!$authService->hasIdentity()) {
            // if not log in, redirect to login page
            return $this->redirect()->toRoute('home');
        }

        $authService->clearIdentity();
        $this->redirect()->toRoute('login');
        //$viewModel->setTemplate('auth/login/login.phtml');
        //return $viewModel;
    }

    public function twitterAction() {
        $consumer = $this->serviceLocator->get('twitter_oauth');
        $token = $consumer->getRequestToken();
        $session = new SessionContainer('twitter_oauth');
        $session->requestToken = serialize($token);
        $consumer->redirect();
    }

    public function twitterCallbackAction() {
        $session = new SessionContainer('twitter_oauth');
        $consumer = $this->serviceLocator->get('twitter_oauth');
        try {
            // get access token
            $token = $consumer->getAccessToken($this->params()->fromQuery(), unserialize($session->requestToken));
            $userTable = $this->getUserTable();
            try {
                // get user by twitter username
                $user = $userTable->getUserByTwitter($token->getParam('screen_name'));
                $userId = $user->id;
            } catch (\Exception $e) {
                // create new user with empty username & password
                $data = array('username' => '',
                    'password' => '',
                    'twitter' => $token->getParam('screen_name')
                );
                $user = new User();
                $user->exchangeArray($data);
                $userTable->saveUser($user);
                $userId = $userTable->getLastInsertUserId();
            }

            $authService = $this->serviceLocator->get('auth_service');
            // get session storage
            $storage = $authService->getStorage();
            // write to session storage
            $storage->write($userId);
            return $this->redirect()->toRoute('home');
        } catch (\ZendOauth\Exception\InvalidArgumentException $e) {
            // if there is error when get access token
            $form = new Login();
            $viewModel = new ViewModel(array('loginMsg' => array($e->getMessage()),
                        'form' => $form,
                        'title' => 'Twitter Sign In'
                    ));
            $viewModel->setTemplate('auth/login/login.phtml');
            return $viewModel;
        }
    }

    public function getUserTable() {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Auth\Model\UserTable');
        }

        return $this->userTable;
    }

}
