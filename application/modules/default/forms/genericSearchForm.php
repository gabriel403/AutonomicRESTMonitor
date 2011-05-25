<?php

class Default_Form_genericSearchForm extends Zend_Dojo_Form {

	public function __construct($data) {

		parent::__construct();
		$this->setName("Search");
		$this->setMethod('post');

		if ( 0 == count($data) )
			return;


		foreach ( $data as $value ) {
			$this->addElement(
				"ValidationTextBox", $value,
				array(
			    'filters' => array('StringTrim'),
			    'validators' => array(
				array('StringLength', false, array(0, 50)),
			    ),
			    'required' => false,
			    'label' => "$value:",
			    'style' => 'width: 80px'
			));
		}
		$this->addElement('SubmitButton', 'login',
			array(
		    'required' => false,
		    'label' => 'Submit',
		));
	}

}