<?php

namespace Auth\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilter;

class Register extends Form {

    public function __construct($name = null) {
        parent::__construct('register');
        $this->setAttribute('method', 'post');
        //$this->setAttribute('action', $this->getView()->baseUrl() . "/");
        
        
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'id' =>'user_name'
            ),
            'options' => array(
                'label' => 'User Email Address',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required',
                'id' =>'user_password'
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        $this->add(array(
            'name' => 'cpassword',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required',
                'id' =>'user_cpassword'
            ),
            'options' => array(
                'label' => 'Confirm Password',
            ),
        ));

      
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Register',
                'id' => 'submitbutton',
            ),
        ));



       
    }

}