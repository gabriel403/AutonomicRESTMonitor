<?php

class Autonomic_Controller_Plugin_AuthCheck extends Zend_Controller_Plugin_Abstract {

	//This is one of the event methods. You can see all of them here: http://framework.zend.com/manual/en/zend.controller.plugins.html
	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
		//Check if zend_auth *this is after using zend_auth to authenticate a user.
		//I'll write a blogpost on this as well*
		//has successfully authenticated the user, and check if the controller and action are not Auth/login.   
		if ( !Zend_Auth::getInstance()->hasIdentity() &&
			Zend_Controller_Front::getInstance()->getRequest()->getModuleName() != 'rest' &&
			(Zend_Controller_Front::getInstance()->getRequest()->getControllerName() != 'login' ||
			Zend_Controller_Front::getInstance()->getRequest()->getActionName() != 'login') ) {
			//If this is the case, get the redirector, and redirect to Auth/login
			$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
			$redirector->gotoUrl("/" . Zend_Controller_Front::getInstance()->getRequest()->getModuleName() . '/login/login');
		}
	}

}