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
        //$dateZone = new \DateTimeZone();
        $dateZone = new \DateTimeZone(date_default_timezone_get());
        $tzlist = $dateZone->listIdentifiers($dateZone::ALL);
        
        foreach($tzlist as $timezone) {
        	$options [$timezone] = $timezone;
        }
        
        
        $this->add(array(
        		'name' => 'default_timezone',
        		'type' => 'select',
        		'attributes' => array(
        				'required' => 'required',
        				'id' =>'timezone'
        		),
        		'options' => array(
        				'label' => 'Default Timezone',
        				'value_options' => $options
        		),
        ));

      
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
            	'class' => 'btn btn-info',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));

    }
}