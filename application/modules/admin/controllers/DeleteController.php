<?php

class Admin_DeleteController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		// action body
	}

	public function usersAction() {
		if ( !$this->_request->isXmlHttpRequest())
			return;
		$id = $this->getRequest()->getParam("id");
		if ( !isset($id) )
			throw new Exception;
		$id_User = Default_Model_Auth::getUserId();
		$dbm = new Access_Model_User();
		try {
			$dbm->delete($id,$id_User);
			echo "SUCCESS";
			exit;
		} catch (Exception $e) {
			echo "FAILURE";
			exit;
		}
	}

	public function sitesAction() {
		if ( !$this->_request->isXmlHttpRequest())
			return;
		$id = $this->getRequest()->getParam("id");
		if ( !isset($id) )
			throw new Exception;
		$id_User = Default_Model_Auth::getUserId();
		$dbm = new Access_Model_Site();
		try {
			$dbm->delete($id,$id_User);
			echo "SUCCESS";
			exit;
		} catch (Exception $e) {
			echo "FAILURE";
			exit;
		}
	}

	public function rolesAction() {
		if ( !$this->_request->isXmlHttpRequest())
			return;
		$id = $this->getRequest()->getParam("id");
		if ( !isset($id) )
			throw new Exception;
		$id_User = Default_Model_Auth::getUserId();
		$dbm = new Access_Model_Role();
		try {
			$dbm->delete($id,$id_User);
			echo "SUCCESS";
			exit;
		} catch (Exception $e) {
			echo "FAILURE";
			exit;
		}
	}

}

