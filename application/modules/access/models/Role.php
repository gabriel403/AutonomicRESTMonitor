<?php

class Access_Model_Role {

    public function __construct() {
        $this->db = new Access_Model_DbTable_Role();
        $this->dma = new Default_Model_Auth();
    }

    public function gets() {
        /*
         * 
         * valid query elements
         * hostname,    the possible hostname %hostname%
         * ip,          the possible IP %ip%
         * isActive,    wether the site is active or no, 1 or 0
         * addedBy,     the id_User or the person who added
         * 
         */
        //TODO: validate that user can add this role, wil need user id from auth
        //TODO: add in all the get shit
        return $this->db->getRoles();
    }

    public function get( $id ) {
        /*
         * 
         * id,  the id of the site
         * 
         */
        $id = (int) $id;
        if( $id && $id > 0 ) {

            if( !$this->dma->userCanDosomething($id_User, "get", "site", $id) )
                throw new Exception("You do not have permission to do that.", "403");
            return $this->db->getRole($id);
        }
        else
            throw new Exception("No id supplied");
    }

    public function add( $name, $canAddUser, $canDeleteUser, $canEditUser,
            $canAddRole, $canDeleteRole, $canEditRole, $canAddSite,
            $canDeleteSite, $canEditSite, $userLimit, $roleLimit, $siteLimit,
            $id_User ) {

        if( !$this->dma->userCanDosomething($id_User, "add", "role") )
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
        if( !$name )
            throw new Exception("No name supplied");
        if( strlen($name) == 0 || strlen($name) > 128 )
            throw new Exception("Invalid  $name length ");

        if( !isset($canAddUser) )
            throw new Exception("Invalid canAddUser $canAddUser");
        $canAddUser = filter_var($canAddUser, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canAddUser) )
            throw new Exception("Invalid canAddUser $canAddUser");

        if( !isset($canDeleteUser) )
            throw new Exception("Invalid canDeleteUser $canDeleteUser");
        $canDeleteUser = filter_var($canDeleteUser, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canDeleteUser) )
            throw new Exception("Invalid canDeleteUser $canDeleteUser");

        if( !isset($canEditUser) )
            throw new Exception("Invalid canEditUser $canEditUser");
        $canEditUser = filter_var($canEditUser, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canEditUser) )
            throw new Exception("Invalid canEditUser $canEditUser");

        if( !isset($canAddRole) )
            throw new Exception("Invalid canAddRole $canAddRole");
        $canAddRole = filter_var($canAddRole, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canAddRole) )
            throw new Exception("Invalid canAddRole $canAddRole");

        if( !isset($canDeleteRole) )
            throw new Exception("Invalid canDeleteRole $canDeleteRole");
        $canDeleteRole = filter_var($canDeleteRole, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canDeleteRole) )
            throw new Exception("Invalid canDeleteRole $canDeleteRole");

        if( !isset($canEditRole) )
            throw new Exception("Invalid canEditRole $canEditRole");
        $canEditRole = filter_var($canEditRole, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canEditRole) )
            throw new Exception("Invalid canEditRole $canEditRole");

        if( !isset($canAddSite) )
            throw new Exception("Invalid canAddSite $canAddSite");
        $canAddSite = filter_var($canAddSite, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canAddSite) )
            throw new Exception("Invalid canAddSite $canAddSite");

        if( !isset($canDeleteSite) )
            throw new Exception("Invalid canDeleteSite $canDeleteSite");
        $canDeleteSite = filter_var($canDeleteSite, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canDeleteSite) )
            throw new Exception("Invalid canDeleteSite $canDeleteSite");

        if( !isset($canEditSite) )
            throw new Exception("Invalid canEditSite $canEditSite");
        $canEditSite = filter_var($canEditSite, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canEditSite) )
            throw new Exception("Invalid canEditSite $canEditSite");

        if( !isset($userLimit) )
            throw new Exception("Invalid userLimit $userLimit");
        $userLimit = filter_var($userLimit, FILTER_VALIDATE_INT, $options);
        if( !isset($userLimit) )
            throw new Exception("Invalid userLimit $userLimit");

        if( !isset($roleLimit) )
            throw new Exception("Invalid roleLimit $roleLimit");
        $roleLimit = filter_var($roleLimit, FILTER_VALIDATE_INT, $options);
        if( !isset($roleLimit) )
            throw new Exception("Invalid roleLimit $roleLimit");

        if( !isset($siteLimit) )
            throw new Exception("Invalid siteLimit $siteLimit");
        $siteLimit = filter_var($siteLimit, FILTER_VALIDATE_INT, $options);
        if( $siteLimit == null )
            throw new Exception("Invalid siteLimit $siteLimit");



        return $this->db->addRole($name, $canAddUser, $canDeleteUser,
                $canEditUser, $canAddRole, $canDeleteRole, $canEditRole,
                $canAddSite, $canDeleteSite, $canEditSite, $userLimit,
                $roleLimit, $siteLimit);
    }

    public function edit( $id, $name, $canAddUser, $canDeleteUser, $canEditUser,
            $canAddRole, $canDeleteRole, $canEditRole, $canAddSite,
            $canDeleteSite, $canEditSite, $userLimit, $roleLimit, $siteLimit,
            $id_User ) {

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
        if( !$id )
            throw new Exception("Invalid  $id");

        if( !$this->dma->userCanDosomething($id_User, "edit", "role", $id) )
            throw new Exception("You do not have permission to do that.", "403");


        $name = filter_var($name, FILTER_SANITIZE_STRING, $options);
        if( !$name )
            throw new Exception("No name supplied");
        if( strlen($name) == 0 || strlen($name) > 128 )
            throw new Exception("Invalid  $name length ");

        if( !isset($canAddUser) )
            throw new Exception("No canAddUser supplied");
        $canAddUser = filter_var($canAddUser, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canAddUser) )
            throw new Exception("Invalid canAddUser $canAddUser");

        if( !isset($canDeleteUser) )
            throw new Exception("Invalid canDeleteUser $canDeleteUser");
        $canDeleteUser = filter_var($canDeleteUser, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canDeleteUser) )
            throw new Exception("Invalid canDeleteUser $canDeleteUser");

        if( !isset($canEditUser) )
            throw new Exception("Invalid canEditUser $canEditUser");
        $canEditUser = filter_var($canEditUser, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canEditUser) )
            throw new Exception("Invalid canEditUser $canEditUser");

        if( !isset($canAddRole) )
            throw new Exception("Invalid canAddRole $canAddRole");
        $canAddRole = filter_var($canAddRole, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canAddRole) )
            throw new Exception("Invalid canAddRole $canAddRole");

        if( !isset($canDeleteRole) )
            throw new Exception("Invalid canDeleteRole $canDeleteRole");
        $canDeleteRole = filter_var($canDeleteRole, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canDeleteRole) )
            throw new Exception("Invalid canDeleteRole $canDeleteRole");

        if( !isset($canEditRole) )
            throw new Exception("Invalid canEditRole $canEditRole");
        $canEditRole = filter_var($canEditRole, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canEditRole) )
            throw new Exception("Invalid canEditRole $canEditRole");

        if( !isset($canAddSite) )
            throw new Exception("Invalid canAddSite $canAddSite");
        $canAddSite = filter_var($canAddSite, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canAddSite) )
            throw new Exception("Invalid canAddSite $canAddSite");

        if( !isset($canDeleteSite) )
            throw new Exception("Invalid canDeleteSite $canDeleteSite");
        $canDeleteSite = filter_var($canDeleteSite, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canDeleteSite) )
            throw new Exception("Invalid canDeleteSite $canDeleteSite");

        if( !isset($canEditSite) )
            throw new Exception("Invalid canEditSite $canEditSite");
        $canEditSite = filter_var($canEditSite, FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE);
        if( !isset($canEditSite) )
            throw new Exception("Invalid canEditSite $canEditSite");

        if( !isset($userLimit) )
            throw new Exception("Invalid userLimit $userLimit");
        $userLimit = filter_var($userLimit, FILTER_VALIDATE_INT, $options);
        if( !isset($userLimit) )
            throw new Exception("Invalid userLimit $userLimit");

        if( !isset($roleLimit) )
            throw new Exception("Invalid roleLimit $roleLimit");
        $roleLimit = filter_var($roleLimit, FILTER_VALIDATE_INT, $options);
        if( !isset($roleLimit) )
            throw new Exception("Invalid roleLimit $roleLimit");

        if( !isset($siteLimit) )
            throw new Exception("Invalid siteLimit $siteLimit");
        $siteLimit = filter_var($siteLimit, FILTER_VALIDATE_INT, $options);
        if( !isset($siteLimit) )
            throw new Exception("Invalid siteLimit $siteLimit");


        return $this->db->editRole($id, $name, $canAddUser, $canDeleteUser,
                $canEditUser, $canAddRole, $canDeleteRole, $canEditRole,
                $canAddSite, $canDeleteSite, $canEditSite, $userLimit,
                $roleLimit, $siteLimit);
    }

    public function delete( $id, $id_User ) {

        $id = (int) $id;
        if( !$id ) {
            throw new Exception("Id is not provided.");
        }
        if( $id < 1 ) {
            throw new Exception("Id is invalid.");
        }

        if( !$this->dma->userCanDosomething($id_User, "delete", "role", $id) )
            throw new Exception("You do not have permission to do that.", "403");

        return $this->db->deleteRole($id);
    }

}

