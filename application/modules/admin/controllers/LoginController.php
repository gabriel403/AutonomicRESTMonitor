<?php

class Admin_LoginController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		// check for user logged in
	}

	public function loginAction() {
		// do formy stuff
		$form = new Default_Form_loginForm();
		$request = $this->getRequest();
		if ( $request->isPost() ) {
			if ( $form->isValid($request->getPost()) ) {
				$bsd = new Default_Model_Auth();
				$username = $request->getParam("username");
				$password = $request->getParam("password");
				if ( $bsd->authenticate($username, $password) )
					echo "VALIDATED";
				else
					echo "NOTVALIDATED";
			}
			else
				echo "NOTVALIDATED";
			exit;
		}
		if ( Zend_Auth::getInstance()->hasIdentity() )
			$this->_redirect($request->getModuleName() . "/");
		$form->setAction("/admin/login/login");
		$this->view->loginform = $form;
	}

	public function logoutAction() {
		Zend_Auth::getInstance()->clearIdentity();
		$this->_helper->redirector('index'); // back to login page
	}

}

