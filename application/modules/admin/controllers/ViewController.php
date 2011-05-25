<?php

class Admin_ViewController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		// action body
	}

	public function usersAction() {

		$request = $this->getRequest();
		$dbm = new Access_Model_User();
		if ( $request->isPost() ) {
//			Zend_Debug::dump($request->getParams());
			$username = $request->getParam("username");
			if ( strlen($username) == 0 )
				$username = -1;
			else
				$username = "%$username%";
			
			$active = $request->getParam("active");
			if ( strlen($active) == 0 )
				$active = -1;

			$id_Role = $request->getParam("id_Role");			
			if ( strlen($id_Role) == 0 )
				$id_Role = -1;

			$id_User = $request->getParam("id_User");
			if ( strlen($id_User) == 0 )
				$id_User = -1;
			
			$limit = $request->getParam("limit");
			if ( strlen($limit) == 0 )
				$limit = 10;
			$offset = $request->getParam("offset");
			if ( strlen($offset) == 0 )
				$offset = 0;
			
			$result = $dbm->gets($limit, $offset, $id_User, $id_Role, $active, $username);
		}
		else
			$result = $dbm->gets();

		$form = new Default_Form_genericViewForm($result);
		$this->view->form = $form;
		
		$dbm2 = new Access_Model_DbTable_User();
		$result = $dbm2->info(Zend_Db_Table_Abstract::COLS);
		unset($result[0]);
		$result[] = "offset";
		$result[] = "limit";
		$searchform = new Default_Form_genericSearchForm($result);
		$searchform->populate($request->getParams());
		$this->view->searchform = $searchform;

	}

	public function sitesAction() {

		$request = $this->getRequest();
		$dbm = new Access_Model_Site();
		if ( $request->isPost() ) {
			$hostname = $request->getParam("hostname");
			if ( strlen($hostname) == 0 )
				$hostname = -1;
			else
				$hostname = "%$hostname%";
			
			$ip = $request->getParam("ip");
			if ( strlen($ip) == 0 )
				$ip = -1;
			else
				$ip = "%$ip%";

			$active = $request->getParam("active");			
			if ( strlen($active) == 0 )
				$active = -1;

			$id_User = $request->getParam("id_User");
			if ( strlen($id_User) == 0 )
				$id_User = -1;
			
			$limit = $request->getParam("limit");
			if ( strlen($limit) == 0 )
				$limit = 10;
			$offset = $request->getParam("offset");
			if ( strlen($offset) == 0 )
				$offset = 0;
			
			$result = $dbm->gets($limit, $offset, $hostname, $ip, $active, $id_User);
		}
		else
			$result = $dbm->gets();

		$form = new Default_Form_genericViewForm($result);
		$this->view->form = $form;
		
		$dbm2 = new Access_Model_DbTable_Site();
		$result = $dbm2->info(Zend_Db_Table_Abstract::COLS);
		unset($result[0]);
		$result[] = "offset";
		$result[] = "limit";
		$searchform = new Default_Form_genericSearchForm($result);
		$searchform->populate($request->getParams());
		$this->view->searchform = $searchform;
	}

	public function rolesAction() {

		$request = $this->getRequest();
		$dbm = new Access_Model_Role();
		if ( $request->isPost() ) {
			$name = $this->getRequest()->getParam("name");
			$name = isset($name) && strlen($name) > 0 ? "%$name%" : "";
			$canAddUser = $this->getRequest()->getParam("canAddUser");
			$canAddUser = isset($canAddUser) && strlen($canAddUser) > 0 ? $canAddUser : -1;
			$canDeleteUser = $this->getRequest()->getParam("canDeleteUser");
			$canDeleteUser = isset($canDeleteUser) && strlen($canDeleteUser) > 0 ? $canDeleteUser : -1;
			$canEditUser = $this->getRequest()->getParam("canEditUser");
			$canEditUser = isset($canEditUser) && strlen($canEditUser) > 0 ? $canEditUser : -1;
			$canAddRole = $this->getRequest()->getParam("canAddRole");
			$canAddRole = isset($canAddRole) && strlen($canAddRole) > 0 ? $canAddRole : -1;
			$canDeleteRole = $this->getRequest()->getParam("canDeleteRole");
			$canDeleteRole = isset($canDeleteRole) && strlen($canDeleteRole) > 0 ? $canDeleteRole : -1;
			$canEditRole = $this->getRequest()->getParam("canEditRole");
			$canEditRole = isset($canEditRole) && strlen($canEditRole) > 0 ? $canEditRole : -1;
			$canAddServer = $this->getRequest()->getParam("canAddServer");
			$canAddServer = isset($canAddServer) && strlen($canAddServer) > 0 ? $canAddServer : -1;
			$canDeleteServer = $this->getRequest()->getParam("canDeleteServer");
			$canDeleteServer = isset($canDeleteServer) && strlen($canDeleteServer) > 0 ? $canDeleteServer : -1;
			$canEditServer = $this->getRequest()->getParam("canEditServer");
			$canEditServer = isset($canEditServer) && strlen($canEditServer) > 0 ? $canEditServer : -1;
			$userLimit = $this->getRequest()->getParam("userLimit");
			$userLimit = isset($userLimit) && strlen($userLimit) > 0 ? $userLimit : -2;
			$roleLimit = $this->getRequest()->getParam("roleLimit");
			$roleLimit = isset($roleLimit) && strlen($roleLimit) > 0 ? $roleLimit : -2;
			$serverLimit = $this->getRequest()->getParam("serverLimit");
			$serverLimit = isset($serverLimit) && strlen($serverLimit) > 0 ? $serverLimit : -2;
			$isAdmin = $this->getRequest()->getParam("isAdmin");
			$isAdmin = isset($isAdmin) && strlen($isAdmin) > 0 ? $isAdmin : -1;

			$limit = $request->getParam("limit");
			if ( strlen($limit) == 0 )
				$limit = 10;
			$offset = $request->getParam("offset");
			if ( strlen($offset) == 0 )
				$offset = 0;
			
			$result = $dbm->gets($limit, $offset, $name, $canAddUser, $canDeleteUser, $canEditUser,
					$canAddRole, $canDeleteRole, $canEditRole, $canAddServer, $canDeleteServer,
					$canEditServer, $userLimit, $roleLimit, $serverLimit);
		}
		else
			$result = $dbm->gets();

		$form = new Default_Form_genericViewForm($result);
		$this->view->form = $form;
		
		$dbm2 = new Access_Model_DbTable_Role();
		$result = $dbm2->info(Zend_Db_Table_Abstract::COLS);
		unset($result[0]);
		$result[] = "offset";
		$result[] = "limit";
		$searchform = new Default_Form_genericSearchForm($result);
		$searchform->populate($request->getParams());
		$this->view->searchform = $searchform;
	}

}

