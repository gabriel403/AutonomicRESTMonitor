<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modularlayout
 *
 * @author gabriel
 */
class Autonomic_Controller_Plugin_Modularlayout extends Zend_Controller_Plugin_Abstract {

	public function routeShutdown(Zend_Controller_Request_Abstract $request) {
		Zend_Layout::getMvcInstance()->setLayout($request->getModuleName());
	}

}

?>
