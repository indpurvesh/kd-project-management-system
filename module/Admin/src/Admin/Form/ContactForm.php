<?php
namespace Admin\Form;

use Zend\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('contact_form');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'first_name',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
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
                'required' => 'required',
                'id' =>'last_name'
            ),
            'options' => array(
                'label' => 'Last Name',
            ),
        ));
        $this->add(array(
            'name' => 'address',
            'attributes' => array(
                'type'  => 'textarea',
                'id' =>'address'
            ),
            'options' => array(
                'label' => 'Addres',
            ),
        ));
    
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add Contact Type',
                'id' => 'submitbutton',
            ),
        ));

    }
}