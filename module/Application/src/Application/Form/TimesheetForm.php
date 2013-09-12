<?php
namespace Application\Form;

use Zend\Form\Form;

class TimesheetForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('timesheet');

        $this->setAttribute('method', 'post');
       

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
                'required' => 'required',
                'id' =>'id'
            ),
        ));
        
        $element = new \Zend\Form\Element('foo', array(
    'label'      => 'Foo',
    'belongsTo'  => 'bar',
    'value'      => 'test',
    'decorators' => array(
        'SimpleInput' => 
        array('SimpleLabel', array('placement' => 'append'))
    ),
));
        $this->add($element);
        
//        $ele = $this->add(array(
//            'name' => 'start_time',
//            'attributes' => array(
//                'type'  => 'datetime-local',
//                'required' => 'required',
//                'class' =>'start_time',
//            ),
//        ));
        
        $this->add(array(
            'name' => 'end_time',
            'belongsTo' => 'test',
            'attributes' => array(
                'type'  => 'datetime-local',
                'required' => 'required',
                'class' =>'end_time'
            ),
        ));
        
        $this->add(array(
            'name' => 'notes',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'class' => 'notes',
            ),
        ));

      
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));

    }
}