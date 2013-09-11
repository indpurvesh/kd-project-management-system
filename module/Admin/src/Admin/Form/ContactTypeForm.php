<?php
namespace Admin\Form;

use Zend\Form\Form;

class ContactTypeForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('contact_type_form');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'contact_type_name',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'id' =>'contact_type_name'
            ),
            'options' => array(
                'label' => 'Contact Type Name',
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