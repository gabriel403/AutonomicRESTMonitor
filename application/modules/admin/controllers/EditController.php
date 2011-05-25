<?php

class Admin_EditController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		// action body
	}

	public function usersAction() {
		$id = $this->getRequest()->getParam("id");
		if ( !isset($id) )
			throw new Exception;
		$request = $this->getRequest();
		$id_User = Default_Model_Auth::getUserId();

		$dbm = new Access_Model_User();
		$user = $dbm->get($id, $id_User);
		if ( $request->isPost() ) {
			$username = $this->getRequest()->getParam("username");
			$username = isset($username) && strlen($username) > 0 ? $username : $user['username'];

			$password = $this->getRequest()->getParam("password");
			$encodedpass = isset($password) && strlen($password) > 0 ? false : true;
			$password = isset($password) && strlen($password) > 0 ? $password : $user['password'];

			$active = $this->getRequest()->getParam("active");
			$active = isset($active) && strlen($active) > 0 ? $active : $user['active'];

			$id_Role = $this->getRequest()->getParam("id_Role");
			$id_Role = isset($id_Role) && strlen($id_Role) > 0 ? $id_Role : $user['id_Role'];
			try {
				$dbm->edit($id, $username, $password, $active, $id_Role, $id_User,
					$encodedpass);

				$user = $dbm->get($id, $id_User);
				unset($user['id']);
				$user['password'] = "";
				$form = new Default_Form_genericEditForm($user);
				$form->populate($user);
				$form->setAction("/admin/edit/users/$id");
				$this->view->form = $form;
				$this->view->errormsg = "Success!";
			} catch ( Exception $e ) {

				unset($user['id']);
				$form = new Default_Form_genericEditForm($user);
				$form->populate($request->getParams());
				$form->setAction("/admin/edit/users/$id");
				$this->view->form = $form;
				$this->view->errormsg = $e->getMessage();
			}
		} else {

			unset($user['id']);
			$user['password'] = "";
			$form = new Default_Form_genericEditForm($user);
			$form->populate($user);
			$form->setAction("/admin/edit/users/$id");
			$this->view->form = $form;
		}
	}

	public function sitesAction() {
		$id = $this->getRequest()->getParam("id");
		if ( !isset($id) )
			throw new Exception;
		$request = $this->getRequest();
		$id_User = Default_Model_Auth::getUserId();

		$dbm = new Access_Model_Site();
		$site = $dbm->get($id, $id_User);
		if ( $request->isPost() ) {
			$hostname = $this->getRequest()->getParam("hostname");
			$hostname = isset($hostname) && strlen($hostname) > 0 ? $hostname : $site['hostname'];

			$ip = $this->getRequest()->getParam("ip");
			$ip = isset($ip) && strlen($ip) > 0 ? $ip : $site['ip'];

			$active = $this->getRequest()->getParam("active");
			$active = isset($active) && strlen($active) > 0 ? $active : $site['active'];
			try {
				$dbm->edit($id, $hostname, $ip, $active, $id_User);

				$site = $dbm->get($id, $id_User);

				unset($site['id']);
				$form = new Default_Form_genericEditForm($site);
				$form->populate($site);
				$form->setAction("/admin/edit/sites/$id");
				$this->view->form = $form;
				$this->view->errormsg = "Success!";
			} catch ( Exception $e ) {

				unset($site['id']);
				$form = new Default_Form_genericEditForm($site);
				$form->populate($request->getParams());
				$form->setAction("/admin/edit/sites/$id");
				$this->view->form = $form;
				$this->view->errormsg = $e->getMessage();
			}
		} else {

			unset($site['id']);
			$form = new Default_Form_genericEditForm($site);
			$form->populate($site);
			$form->setAction("/admin/edit/sites/$id");
			$this->view->form = $form;
		}
	}

	public function rolesAction() {
		$id = $this->getRequest()->getParam("id");
		if ( !isset($id) )
			throw new Exception;
		$request = $this->getRequest();
		$id_User = Default_Model_Auth::getUserId();

		$dbm = new Access_Model_Role();
		$role = $dbm->get($id, $id_User);
		if ( $request->isPost() ) {
			$name = $this->getRequest()->getParam("name");
			$name = isset($name) && strlen($name) > 0 ? $name : $role['name'];
			$canAddUser = $this->getRequest()->getParam("canAddUser");
			$canAddUser = isset($canAddUser) && strlen($canAddUser) > 0 ? $canAddUser : $role['canAddUser'];
			$canDeleteUser = $this->getRequest()->getParam("canDeleteUser");
			$canDeleteUser = isset($canDeleteUser) && strlen($canDeleteUser) > 0 ? $canDeleteUser : $role['canDeleteUser'];
			$canEditUser = $this->getRequest()->getParam("canEditUser");
			$canEditUser = isset($canEditUser) && strlen($canEditUser) > 0 ? $canEditUser : $role['canEditUser'];
			$canAddRole = $this->getRequest()->getParam("canAddRole");
			$canAddRole = isset($canAddRole) && strlen($canAddRole) > 0 ? $canAddRole : $role['canAddRole'];
			$canDeleteRole = $this->getRequest()->getParam("canDeleteRole");
			$canDeleteRole = isset($canDeleteRole) && strlen($canDeleteRole) > 0 ? $canDeleteRole : $role['canDeleteRole'];
			$canEditRole = $this->getRequest()->getParam("canEditRole");
			$canEditRole = isset($canEditRole) && strlen($canEditRole) > 0 ? $canEditRole : $role['canEditRole'];
			$canAddServer = $this->getRequest()->getParam("canAddServer");
			$canAddServer = isset($canAddServer) && strlen($canAddServer) > 0 ? $canAddServer : $role['canAddServer'];
			$canDeleteServer = $this->getRequest()->getParam("canDeleteServer");
			$canDeleteServer = isset($canDeleteServer) && strlen($canDeleteServer) > 0 ? $canDeleteServer : $role['canDeleteServer'];
			$canEditServer = $this->getRequest()->getParam("canEditServer");
			$canEditServer = isset($canEditServer) && strlen($canEditServer) > 0 ? $canEditServer : $role['canEditServer'];
			$userLimit = $this->getRequest()->getParam("userLimit");
			$userLimit = isset($userLimit) && strlen($userLimit) > 0 ? $userLimit : $role['userLimit'];
			$roleLimit = $this->getRequest()->getParam("roleLimit");
			$roleLimit = isset($roleLimit) && strlen($roleLimit) > 0 ? $roleLimit : $role['roleLimit'];
			$serverLimit = $this->getRequest()->getParam("serverLimit");
			$serverLimit = isset($serverLimit) && strlen($serverLimit) > 0 ? $serverLimit : $role['serverLimit'];
			$isAdmin = $this->getRequest()->getParam("isAdmin");
			$isAdmin = isset($isAdmin) && strlen($isAdmin) > 0 ? $isAdmin : $role['isAdmin'];
			try {
				$dbm->edit($id, $name, $canAddUser, $canDeleteUser, $canEditUser,
					$canAddRole, $canDeleteRole, $canEditRole, $canAddServer, $canDeleteServer,
					$canEditServer, $userLimit, $roleLimit, $serverLimit, $id_User);

				$role = $dbm->get($id, $id_User);

				unset($role['id']);
				$form = new Default_Form_genericEditForm($role);
				$form->populate($role);
				$form->setAction("/admin/edit/roles/$id");
				$this->view->form = $form;
				$this->view->errormsg = "Success!";
			} catch ( Exception $e ) {

				unset($role['id']);
				$form = new Default_Form_genericEditForm($role);
				$form->populate($request->getParams());
				$form->setAction("/admin/edit/roles/$id");
				$this->view->form = $form;
				$this->view->errormsg = $e->getMessage();
			}
		} else {

			unset($role['id']);
			$form = new Default_Form_genericEditForm($role);
			$form->populate($role);
			$form->setAction("/admin/edit/roles/$id");
			$this->view->form = $form;
		}
	}

}

