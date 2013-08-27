<?php

class Default_Form_TradeMeToTagmyjob extends Kdecom_Form_Base {

    public function _createButton() {
        $this->createElement('button', 'convert','Convert to Tagmyjob');
        $this->createElement('button', 'copy','Copy');
        $this->createElement('button', 'delete','Delete');
        $this->addDisplayGroup(array($this->convert,$this->copy,$this->delete), 'buttongroup');
    }


    public function init() {
        $this->_createFormElements();
        $this->_createTagFormElements();
        $this->_createButton();
    }
    
    public function _createTagFormElements() {

        $locationModel = new Application_Model_Table_Location();
        $categoryModel = new Application_Model_Table_Category();
        $tagModel = new Application_Model_Table_Tag();


        $category = $this->createElement('select', 'category_id', 'Category')
                        ->setMultiOptions($categoryModel->getParentOptions());
        $subCategory = $this->createElement('select', 'sub_category_id', 'Sub Category')
                        ->setMultiOptions(array('' => "Please Select Category"));
        $jobDescription = $this->createElement('textarea', 'tag_job_description', 'Job Description', 
                array('rows' => 10, 'cols' => 50))
                ->setAttrib('class', 'tinymce')

                        ;

        $location = $this->createElement('select', 'tag_location_id', 'Location')
                        ->setMultiOptions($locationModel->getLocationOptions(false));
        $area = $this->createElement('select', 'area_id', 'Area')
                        ->setMultiOptions($locationModel->getLocationOptions(false));
        $this->createElement('text', 'tag_job_name','Tag Job Name');

        $this->createElement('select', 'tag_job_type','TradeMe job type')
                ->setMultiOptions(array(
                    '1' => 'FullTime',
                    '2' => 'PartTime',
                    '3' => 'Contract',
                    '4' => 'Causal / call basis'
                ));
        $this->createElement('text', 'tag_job_date','TradeMe job date');
        $this->createElement('text', 'tag_job_url','TradeMe job url');

        $this->addDisplayGroup(array(
            $this->tag_location_id,
            $this->area_id,
            $this->category_id,
            $this->sub_category_id,
            $this->tag_job_name,
            $this->tag_job_description,
            $this->tag_job_type,
            $this->tag_job_date,
            $this->tag_job_url,

        ), 'TagData');
    }
    private function _createFormElements(){

        $this->createElement('hidden', 'id');
        $this->createElement('text', 'job_name','TradeMe Job Name');
        $this->createElement('textarea', 'job_description','TradeMe Job Description')
                ->setAttribs(array('rows'=>2,'cols'=>80));
        $this->createElement('text', 'category_path','TradeMe Category');
        $this->createElement('text', 'region','TradeMe Region');
        $this->createElement('text', 'subrd','TradeMe Subrd');
        $this->createElement('text', 'job_type','TradeMe job type');
        $this->createElement('text', 'job_date','TradeMe job date');
        $this->createElement('text', 'job_url','TradeMe job URL');

        $this->addDisplayGroup(array(
            $this->job_name,
            $this->job_description,
            $this->job_type,
            $this->job_date,
            $this->job_url,
            $this->category_path,
            $this->region,
            $this->subrd,

        ), 'TradeMeData');
    }



}