<?php
namespace Admin\Form;

use Zend\Form\Form;

class CoreSystemSettingsForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('coresystemsettings');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'application_name',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                'id' =>'application_name'
            ),
            'options' => array(
                'label' => 'Application Name',
            ),
        ));

      
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));

    }
}