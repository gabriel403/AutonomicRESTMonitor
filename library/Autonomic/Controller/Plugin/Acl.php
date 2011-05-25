<?php

class Autonomic_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

	public function preDispatch(Zend_Controller_Request_Abstract $request) {

		if (strcasecmp("rest", $request->getModuleName()) == 0)
			return;

		$auth = Zend_Auth::getInstance();
		$acl = new Default_Model_Acl();


		$dma = new Default_Model_Auth();
		if (!$auth->hasIdentity()) {
			$request->setControllerName('login')
				->setActionName('login');
			return;
		}
		if ($dma->isAdmin($dma->getUserId()))
			$role = "admin";
		else
			$role = "user";

// Mapping to determine which Resource the current
// request refers to (really simple for this example!)
		$resource = $request->getModuleName();

		if (!$acl->has($resource)) {
			$resource = null;
		}
// ACL Access Check
		if (!$acl->isAllowed($role, $resource)) {
			if ($auth->hasIdentity()) {
// authenticated, denied access, forward to index
				$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
				$redirector->gotoUrl('/');
			} else {
// not authenticated, forward to login form
				$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
				$redirector->gotoUrl('/login/login');
			}
		}
	}

}