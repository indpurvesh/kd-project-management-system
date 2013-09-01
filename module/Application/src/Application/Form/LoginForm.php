<?php
namespace Application\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('login');

        $this->setAttribute('method', 'post');
       

        $this->add(array(
            'name' => 'user_name',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'id' =>'user_name'
            ),
            'options' => array(
                'label' => 'User Name',
            ),
        ));
        $this->add(array(
            'name' => 'user_password',
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
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
                'id' => 'submitbutton',
            ),
        ));

    }
}