<?php

class Kdecom_Controller_Admin extends Zend_Controller_Action {

    public function head() {
        return $this->__call('head');
    }

    public function init() {
        //$this->_logVisitor();
        $this->_helper->layout->setLayout('layout_admin');
        $this->_addHelperPath();
        $this->authenticate();
    }

    public function sendEmail($to, $subject, $template, $data = array(), $attachment = null) {

        $config = array(
            'ssl' => 'tls',
            'port' => 587,
            'auth' => 'login',
            'username' => 'info@tagmyjob.co.nz',
            'password' => 'auckland123');

        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);



        // create view object
        $html = new Zend_View();
        $html->setScriptPath(APPLICATION_PATH . '/../email/template/');
        $html->assign('data', $data);

        $mail = new Zend_Mail('utf-8');
        $bodyText = $html->render($template);
        $mail->addTo($to);

        $mail->setSubject($subject);
        $mail->setFrom('info@tagmyjob.co.nz', 'TagMyJob');
        $mail->setBodyHtml($bodyText);


        if ($attachment !== null) {
            foreach ($attachment as $filePath) {
                $arrayPath = explode("/", $filePath);

                $fileContents = file_get_contents($filePath);
                $file = $mail->createAttachment($fileContents);
                $file->filename = $arrayPath[7];
            }
        }


        $mail->send($transport);
    }

    private function _logVisitor() {
        $model = new Application_Model_Table_LogVisitor();
        $data = array(
            'visitor_ip' => $_SERVER['REMOTE_ADDR'],
            'visitor_user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'visitor_referer' => (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null,
            'visitor_url' => $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        );

        try {
            $model->insert($data);
        } catch (Zend_Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function authenticate() {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_redirect(APPLICATION_URL . '/user/index/login');
        }
    }

    public function uploadFile($path) {
        try {
            $adapter = new Zend_File_Transfer_Adapter_Http();
            $adapter->setDestination($path);
            $files = $adapter->getFileInfo();

            foreach ($files as $fieldname => $fileinfo) {

                if ($adapter->isValid($fileinfo['name'])) {

                    $fileName = $fieldname . "-" . $fileinfo['name'];
                    for ($i = 0; $i < 10; $i++) {
                        //if($this->_isFileExist($fileinfo['destination'], $fileinfo['name']) ===null){
                        if (file_exists($fileinfo['destination'] . "/" . $fileName) === false) {
                            break;
                        }
                        $fileName = rand(0, 1000) . $fileinfo['name'];
                    }
                    $newPath = $fileinfo['destination'] . "/" . $fileName;

                    $adapter->addFilter('Rename', array('target' => $newPath, 'overwrite' => true));
                    //NEW NAME replace 1111 with user ID;;;;

                    if ($adapter->receive($fileinfo['name']) === true) {
                        //$adapter->filter($fileinfo['name']);
                        //return new path SAVE $newPath in database;

                        $return [$fieldname] = $newPath;
                    }
                }
            }
            return $return;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    private function _addHelperPath() {
        $this->view->addHelperPath('Kdecom/View/Helper/', 'Kdecom_View_Helper');
    }

}
