<?php
namespace Admin\Form;

use Zend\Form\Form;

class ProjectForm extends Form
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
            'name' => 'description',
            'attributes' => array(
                'type'  => 'textarea',
                'required' => 'required',
                'id' =>'description'
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));
//        $this->add(array(
//            'name' => 'address',
//            'attributes' => array(
//                'type'  => 'textarea',
//                'id' =>'address'
//            ),
//            'options' => array(
//                'label' => 'Addres',
//            ),
//        ));
    
       

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add Project',
                'id' => 'submitbutton',
            ),
        ));

    }
}