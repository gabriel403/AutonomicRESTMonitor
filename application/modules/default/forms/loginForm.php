<?php

class Default_Form_loginForm extends Zend_Dojo_Form {

    public function init() {
        $this->setName("Login");
        $this->setMethod('post');

        $this->addElement('ValidationTextBox', 'username',
                array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Username:',
        ));

        $this->addElement('PasswordTextBox', 'password',
                array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Password:',
        ));

        $this->addElement('SubmitButton', 'login',
                array(
            'required' => false,
//            'ignore' => true,
            'label' => 'Login',
        ));
    }

}