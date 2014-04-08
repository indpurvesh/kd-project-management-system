<?php
namespace Report\Form;

use Zend\Form\Form;

class HoursByEmployeeForm extends Form
{
    public function __construct($name = 'hours_worked_by_employee')
    {
        parent::__construct($name);

        $this->setAttribute('method', 'post');
       
        $this->add(array(
        		'name' => 'employee',
        		'type'  => 'select',
        		'options' => array(
        				'label' => 'Employee'
        		),
        ));

        $this->add(array(
            'name' => 'from_date',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'id' =>'from_date'
            ),
            'options' => array(
                'label' => 'From Date',
            ),
        ));
        $this->add(array(
            'name' => 'to_date',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'id' =>'to_date'
            ),
            'options' => array(
                'label' => 'To Date',
            ),
        ));

        $this->add(array(
        		'name' => 'group_by',
        		'type'  => 'select',
        		'options' => array(
        				'label' => 'Group By'
        		),
        ));
      
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Display Report',
                'id' => 'submitbutton',
            ),
        ));

    }
}