<?php

class Default_Form_genericEditForm extends Zend_Dojo_Form {

	public function __construct($data) {

		parent::__construct();
		$this->setName("Edit");
		$this->setMethod('post');

		if ( !isset($data) || !$data )
			return;

		foreach ( $data as $key => $value ) {
			$this->addElement(
				"ValidationTextBox", $key, array(
			    'filters' => array('StringTrim'),
			    'validators' => array(
				array('StringLength', false, array(0, 50)),
			    ),
			    'required' => false,
			    'label' => "$key:"
			));
		}
		$this->addElement('SubmitButton', 'login', array(
		    'required' => false,
		    'label' => 'Submit',
		));
	}

}