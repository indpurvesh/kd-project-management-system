<?php
namespace Admin\Form;

use Zend\Form\Form;

class RoleForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('role_form');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'role_name',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'id' =>'role_name'
            ),
            'options' => array(
                'label' => 'Role Name',
            ),
        ));
    
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add Role',
                'id' => 'submitbutton',
            ),
        ));

    }
}