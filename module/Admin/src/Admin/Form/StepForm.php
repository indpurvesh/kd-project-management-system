<?php
namespace Admin\Form;

use Zend\Form\Form;

class StepForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('step_form');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'id' =>'name'
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'parent_step_id',
            'type'  => 'select',
            'attributes' => array(
                'required' => 'required',
                'id' =>'parent_step_id',
            ),
            'options' => array(
                'label' => 'Parent Step',
            ),
        ));
        
    
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add Step',
                'id' => 'submitbutton',
            ),
        ));

    }
}