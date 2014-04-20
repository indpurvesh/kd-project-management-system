<?php
namespace Admin\Form;

use Zend\Form\Form,
    Admin\Model\RoleTable    
        ;

class RoleAccessForm extends Form
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
            'name' => 'role_id',
            'type'  => 'select',
            'attributes' => array(
                'required' => 'required',
                'id' =>'role_name',
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
            		'class' => 'btn btn-large btn-block btn-success',
                'id' => 'submitbutton',
            ),
        ));

        $this->add(array(
        		'name' => 'cancel',
        		'attributes' => array(
        				'type'  => 'button',
        				'value' => 'Cancel',
        				'class' => 'btn btn-large btn-block',
        				'id' => 'submitbutton',
        		),
        ));
    }
}