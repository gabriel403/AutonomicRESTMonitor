<?php

class Access_Model_Role {

	public function __construct() {
		$this->db = new Access_Model_DbTable_Role();
		$this->dma = new Default_Model_Auth();
	}

	public function gets($limit = 10, $offset = 0, $name = "", $canAddUser = -1, $canDeleteUser = -1,
		$canEditUser = -1, $canAddRole = -1, $canDeleteRole = -1, $canEditRole = -1, $canAddServer = -1,
		$canDeleteServer = -1, $canEditServer = -1, $userLimit = -2, $roleLimit = -2, $serverLimit = -2) {

		$options = array(
		    'options' => array(
			'default' => null
		    )
		);

		if ( !isset($limit) )
			$limit = 10;
		$limit = filter_var($limit, FILTER_VALIDATE_INT, $options);
		if ( null === $limit )
			throw new Exception("Invalid limit $limit");

		if ( !isset($offset) )
			$offset = 0;
		$offset = filter_var($offset, FILTER_VALIDATE_INT, $options);
		if ( null === $offset )
			throw new Exception("Invalid offset $offset");

		//validate $name
		if ( !isset($name) )
			$name = null;
		$name = filter_var($name, FILTER_SANITIZE_STRING,
			array(FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH));
		if ( null === $name )
			throw new Exception("Invalid name $name");
		if ( strlen($name) > 64 )
			throw new Exception("Invalid name length $name");
		if (  strlen($name) == 0)
			$name = -1;

		if ( !isset($canAddUser) )
			$canAddUser = -1;
		$canAddUser = filter_var($canAddUser, FILTER_VALIDATE_INT, $options);
		if ( null === $canAddUser )
			throw new Exception("Invalid canAddUser $canAddUser");

		if ( !isset($canDeleteUser) )
			$canDeleteUser = -1;
		$canDeleteUser = filter_var($canDeleteUser, FILTER_VALIDATE_INT, $options);
		if ( null === $canDeleteUser )
			throw new Exception("Invalid \$canDeleteUser $canDeleteUser");

		if ( !isset($canEditUser) )
			$canEditUser = -1;
		$canEditUser = filter_var($canEditUser, FILTER_VALIDATE_INT, $options);
		if ( null === $canEditUser )
			throw new Exception("Invalid \$canEditUser $canEditUser");

		if ( !isset($canAddRole) )
			$canAddRole = -1;
		$canAddRole = filter_var($canAddRole, FILTER_VALIDATE_INT, $options);
		if ( null === $canAddRole )
			throw new Exception("Invalid \$canAddRole $canAddRole");

		if ( !isset($canDeleteRole) )
			$canDeleteRole = -1;
		$canDeleteRole = filter_var($canDeleteRole, FILTER_VALIDATE_INT, $options);
		if ( null === $canDeleteRole )
			throw new Exception("Invalid \$canDeleteRole $canDeleteRole");

		if ( !isset($canEditRole) )
			$canEditRole = -1;
		$canEditRole = filter_var($canEditRole, FILTER_VALIDATE_INT, $options);
		if ( null === $canEditRole )
			throw new Exception("Invalid \$canEditRole $canEditRole");

		if ( !isset($canAddServer) )
			$canAddServer = -1;
		$canAddServer = filter_var($canAddServer, FILTER_VALIDATE_INT, $options);
		if ( null === $canAddServer )
			throw new Exception("Invalid \$canAddServer $canAddServer");

		if ( !isset($canDeleteServer) )
			$canDeleteServer = -1;
		$canDeleteServer = filter_var($canDeleteServer, FILTER_VALIDATE_INT, $options);
		if ( null === $canDeleteServer )
			throw new Exception("Invalid \$canDeleteServer $canDeleteServer");

		if ( !isset($canEditServer) )
			$canEditServer = -1;
		$canEditServer = filter_var($canEditServer, FILTER_VALIDATE_INT, $options);
		if ( null === $canEditServer )
			throw new Exception("Invalid \$canEditServer $canEditServer");

		if ( !isset($userLimit) )
			$userLimit = -2;
		$userLimit = filter_var($userLimit, FILTER_VALIDATE_INT, $options);
		if ( null === $userLimit )
			throw new Exception("Invalid \$userLimit $userLimit");

		if ( !isset($roleLimit) )
			$roleLimit = -2;
		$roleLimit = filter_var($roleLimit, FILTER_VALIDATE_INT, $options);
		if ( null === $roleLimit )
			throw new Exception("Invalid \$roleLimit $roleLimit");

		if ( !isset($serverLimit) )
			$serverLimit = -2;
		$serverLimit = filter_var($serverLimit, FILTER_VALIDATE_INT, $options);
		if ( null === $serverLimit )
			throw new Exception("Invalid \$serverLimit $serverLimit");

		$roles = $this->db->getRoles($limit, $offset, $name, $canAddUser, $canDeleteUser,
		$canEditUser, $canAddRole, $canDeleteRole, $canEditRole, $canAddServer,
		$canDeleteServer, $canEditServer, $userLimit, $roleLimit, $serverLimit);
		
		$id_User = Default_Model_Auth::getUserId();
		foreach ( $roles as $key => $role ) {
			if ( !$this->dma->userCanDosomething($id_User, "get", "role", $role['id']) )
				unset($roles[$key]);
		}
		return $roles;
	}

	public function get($id, $id_User) {
		/*
		 * 
		 * id,  the id of the site
		 * 
		 */
		$id = (int) $id;
		if ( $id && $id > 0 ) {

			//if ( !$this->dma->userCanDosomething($id_User, "get", "role", $id) )
			//	throw new Exception("You do not have permission to do that.", "403");
			return $this->db->getRole($id);
		}
		else
			throw new Exception("No id supplied");
	}

	public function add($name, $canAddUser, $canDeleteUser, $canEditUser,
		$canAddRole, $canDeleteRole, $canEditRole, $canAddServer, $canDeleteServer,
		$canEditServer, $userLimit, $roleLimit, $serverLimit, $id_User) {

		if ( !$this->dma->userCanDosomething($id_User, "add", "role") )
			throw new Exception("You do not have permission to do that.", "403");

		$options = array(
		    'options' => array(
			'default' => null
		    )
		);
		/*
		 * validate shizzle
		 */
		$name = filter_var($name, FILTER_SANITIZE_STRING, $options);
		if ( !$name )
			throw new Exception("No name supplied");
		if ( strlen($name) == 0 || strlen($name) > 128 )
			throw new Exception("Invalid  $name length ");

		if ( !isset($canAddUser) )
			throw new Exception("Invalid canAddUser $canAddUser");
		$canAddUser = filter_var($canAddUser, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canAddUser) )
			throw new Exception("Invalid canAddUser $canAddUser");

		if ( !isset($canDeleteUser) )
			throw new Exception("Invalid canDeleteUser $canDeleteUser");
		$canDeleteUser = filter_var($canDeleteUser, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canDeleteUser) )
			throw new Exception("Invalid canDeleteUser $canDeleteUser");

		if ( !isset($canEditUser) )
			throw new Exception("Invalid canEditUser $canEditUser");
		$canEditUser = filter_var($canEditUser, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canEditUser) )
			throw new Exception("Invalid canEditUser $canEditUser");

		if ( !isset($canAddRole) )
			throw new Exception("Invalid canAddRole $canAddRole");
		$canAddRole = filter_var($canAddRole, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canAddRole) )
			throw new Exception("Invalid canAddRole $canAddRole");

		if ( !isset($canDeleteRole) )
			throw new Exception("Invalid canDeleteRole $canDeleteRole");
		$canDeleteRole = filter_var($canDeleteRole, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canDeleteRole) )
			throw new Exception("Invalid canDeleteRole $canDeleteRole");

		if ( !isset($canEditRole) )
			throw new Exception("Invalid canEditRole $canEditRole");
		$canEditRole = filter_var($canEditRole, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canEditRole) )
			throw new Exception("Invalid canEditRole $canEditRole");

		if ( !isset($canAddServer) )
			throw new Exception("Invalid canAddServer $canAddServer");
		$canAddServer = filter_var($canAddServer, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canAddServer) )
			throw new Exception("Invalid canAddServer $canAddServer");

		if ( !isset($canDeleteServer) )
			throw new Exception("Invalid canDeleteServer $canDeleteServer");
		$canDeleteServer = filter_var($canDeleteServer, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canDeleteServer) )
			throw new Exception("Invalid canDeleteServer $canDeleteServer");

		if ( !isset($canEditServer) )
			throw new Exception("Invalid canEditServer $canEditServer");
		$canEditServer = filter_var($canEditServer, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canEditServer) )
			throw new Exception("Invalid canEditServer $canEditServer");

		if ( !isset($userLimit) )
			throw new Exception("Invalid userLimit $userLimit");
		$userLimit = filter_var($userLimit, FILTER_VALIDATE_INT, $options);
		if ( !isset($userLimit) )
			throw new Exception("Invalid userLimit $userLimit");

		if ( !isset($roleLimit) )
			throw new Exception("Invalid roleLimit $roleLimit");
		$roleLimit = filter_var($roleLimit, FILTER_VALIDATE_INT, $options);
		if ( !isset($roleLimit) )
			throw new Exception("Invalid roleLimit $roleLimit");

		if ( !isset($serverLimit) )
			throw new Exception("Invalid serverLimit $serverLimit");
		$serverLimit = filter_var($serverLimit, FILTER_VALIDATE_INT, $options);
		if ( $serverLimit == null )
			throw new Exception("Invalid serverLimit $serverLimit");



		return $this->db->addRole($name, $canAddUser, $canDeleteUser, $canEditUser,
			$canAddRole, $canDeleteRole, $canEditRole, $canAddServer, $canDeleteServer,
			$canEditServer, $userLimit, $roleLimit, $serverLimit);
	}

	public function edit($id, $name, $canAddUser, $canDeleteUser, $canEditUser,
		$canAddRole, $canDeleteRole, $canEditRole, $canAddServer, $canDeleteServer,
		$canEditServer, $userLimit, $roleLimit, $serverLimit, $id_User) {

		$options = array(
		    'options' => array(
			'default' => null
		    )
		);

		/*
		 * validate shizzle
		 */
		$editArray = array();

		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ( !$id )
			throw new Exception("Invalid  $id");

		if ( !$this->dma->userCanDosomething($id_User, "edit", "role", $id) )
			throw new Exception("You do not have permission to do that.", "403");


		$name = filter_var($name, FILTER_SANITIZE_STRING, $options);
		if ( !$name )
			throw new Exception("No name supplied");
		if ( strlen($name) == 0 || strlen($name) > 128 )
			throw new Exception("Invalid  $name length ");

		if ( !isset($canAddUser) )
			throw new Exception("No canAddUser supplied");
		$canAddUser = filter_var($canAddUser, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canAddUser) )
			throw new Exception("Invalid canAddUser $canAddUser");

		if ( !isset($canDeleteUser) )
			throw new Exception("Invalid canDeleteUser $canDeleteUser");
		$canDeleteUser = filter_var($canDeleteUser, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canDeleteUser) )
			throw new Exception("Invalid canDeleteUser $canDeleteUser");

		if ( !isset($canEditUser) )
			throw new Exception("Invalid canEditUser $canEditUser");
		$canEditUser = filter_var($canEditUser, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canEditUser) )
			throw new Exception("Invalid canEditUser $canEditUser");

		if ( !isset($canAddRole) )
			throw new Exception("Invalid canAddRole $canAddRole");
		$canAddRole = filter_var($canAddRole, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canAddRole) )
			throw new Exception("Invalid canAddRole $canAddRole");

		if ( !isset($canDeleteRole) )
			throw new Exception("Invalid canDeleteRole $canDeleteRole");
		$canDeleteRole = filter_var($canDeleteRole, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canDeleteRole) )
			throw new Exception("Invalid canDeleteRole $canDeleteRole");

		if ( !isset($canEditRole) )
			throw new Exception("Invalid canEditRole $canEditRole");
		$canEditRole = filter_var($canEditRole, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canEditRole) )
			throw new Exception("Invalid canEditRole $canEditRole");

		if ( !isset($canAddServer) )
			throw new Exception("Invalid canAddServer $canAddServer");
		$canAddServer = filter_var($canAddServer, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canAddServer) )
			throw new Exception("Invalid canAddServer $canAddServer");

		if ( !isset($canDeleteServer) )
			throw new Exception("Invalid canDeleteServer $canDeleteServer");
		$canDeleteServer = filter_var($canDeleteServer, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canDeleteServer) )
			throw new Exception("Invalid canDeleteServer $canDeleteServer");

		if ( !isset($canEditServer) )
			throw new Exception("Invalid canEditServer $canEditServer");
		$canEditServer = filter_var($canEditServer, FILTER_VALIDATE_BOOLEAN,
			FILTER_NULL_ON_FAILURE);
		if ( !isset($canEditServer) )
			throw new Exception("Invalid canEditServer $canEditServer");

		if ( !isset($userLimit) )
			throw new Exception("Invalid userLimit $userLimit");
		$userLimit = filter_var($userLimit, FILTER_VALIDATE_INT, $options);
		if ( !isset($userLimit) )
			throw new Exception("Invalid userLimit $userLimit");

		if ( !isset($roleLimit) )
			throw new Exception("Invalid roleLimit $roleLimit");
		$roleLimit = filter_var($roleLimit, FILTER_VALIDATE_INT, $options);
		if ( !isset($roleLimit) )
			throw new Exception("Invalid roleLimit $roleLimit");

		if ( !isset($serverLimit) )
			throw new Exception("Invalid serverLimit $serverLimit");
		$serverLimit = filter_var($serverLimit, FILTER_VALIDATE_INT, $options);
		if ( !isset($serverLimit) )
			throw new Exception("Invalid serverLimit $serverLimit");


		return $this->db->editRole($id, $name, $canAddUser, $canDeleteUser,
			$canEditUser, $canAddRole, $canDeleteRole, $canEditRole, $canAddServer,
			$canDeleteServer, $canEditServer, $userLimit, $roleLimit, $serverLimit);
	}

	public function delete($id, $id_User) {

		$id = (int) $id;
		if ( !$id ) {
			throw new Exception("Id is not provided.");
		}
		if ( $id < 1 ) {
			throw new Exception("Id is invalid.");
		}

		if ( !$this->dma->userCanDosomething($id_User, "delete", "role", $id) )
			throw new Exception("You do not have permission to do that.", "403");

		return $this->db->deleteRole($id);
	}

}

