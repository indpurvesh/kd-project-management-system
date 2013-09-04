<?php
namespace Admin\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('user_info');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

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
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'id' =>'email'
            ),
            'options' => array(
                'label' => 'User Email',
            ),
        ));
        $this->add(array(
            'name' => 'user_password',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required',
                'id' =>'password'
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        $this->add(array(
            'name' => 'first_name',
            'attributes' => array(
                'type'  => 'text',
                'id' =>'first_name'
            ),
            'options' => array(
                'label' => 'First Name',
            ),
        ));
        $this->add(array(
            'name' => 'last_name',
            'attributes' => array(
                'type'  => 'text',
                'id' =>'first_name'
            ),
            'options' => array(
                'label' => 'Last Name',
            ),
        ));

      
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Update Login',
                'id' => 'submitbutton',
            ),
        ));

    }
}