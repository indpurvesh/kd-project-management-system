<?php
namespace Auth\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\InputFilter\Factory as InputFactory,
	Zend\InputFilter\InputFilter;

class Login extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        //$this->setAttribute('action', $this->getView()->baseUrl() . "/");
        
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'id' =>'user_name',
                'value' => 'admin'
            ),
            'options' => array(
                'label' => 'User Name',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required',
                'id' =>'user_password',
                'value' =>'admin123'
            ),
            'options' => array(
                'label' => 'Password',
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