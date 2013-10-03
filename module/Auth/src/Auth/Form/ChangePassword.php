<?php
namespace Auth\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\InputFilter\Factory as InputFactory,
	Zend\InputFilter\InputFilter;

class ChangePassword extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        //$this->setAttribute('action', $this->getView()->baseUrl() . "/");
        
        $this->add(array(
            'name' => 'old_password',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required',
                'id' =>'old_password',
            ),
            'options' => array(
                'label' => 'Old Password',
            ),
        ));
        $this->add(array(
            'name' => 'new_password',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required',
                'id' =>'new_password',
            ),
            'options' => array(
                'label' => 'New Password',
            ),
        ));
        $this->add(array(
            'name' => 'c_new_password',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required',
                'id' =>'c_new_password',
            ),
            'options' => array(
                'label' => 'Confirm New Password',
            ),
        ));

      
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
                'class' => 'btn btn-large btn-block btn-success',
                'id' => 'submitbutton',
            ),
        ));

    }
}