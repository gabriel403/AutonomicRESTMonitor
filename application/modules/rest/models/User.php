<?php

class Rest_Model_User {

    public function __construct() {
        $this->db = new Access_Model_DbTable_User();
    }

    /**
     * 
     * valid query elements
     * limit,   the limited range of elements returned
     * offset,  The number of elements to skip before we find values to return
     * addedBy, gets all the user with a specific id_User
     * role,    limits the result to those with the specified id_Role
     * active,  limits to wether the user is active
     * 
     */
    public function gets( $limit = 10, $offset = 0, $id_User = false,
            $id_Role = false, $active = -1, $username = -1 ) {

        //echo "'".Default_Model_Auth::getUserId()."'";
        //TODO: validate that user can see users, wil need user id from auth



        $options = array(
            'options' => array(
                'default' => null
            )
        );

        if( !isset($limit) )
            $limit = 10;
        $limit = filter_var($limit, FILTER_VALIDATE_INT, $options);
        if( null === $limit )
            throw new Exception("Invalid limit $limit");

        if( !isset($offset) )
            $offset = 0;
        $offset = filter_var($offset, FILTER_VALIDATE_INT, $options);
        if( null === $offset )
            throw new Exception("Invalid offset $offset");

        if( !isset($id_User) )
            $id_User = -1;
        $id_User = filter_var($id_User, FILTER_VALIDATE_INT, $options);
        if( null === $id_User )
            throw new Exception("Invalid id_User $id_User");

        if( !isset($id_Role) )
            $id_Role = -1;
        $id_Role = filter_var($id_Role, FILTER_VALIDATE_INT, $options);
        if( null === $id_Role )
            throw new Exception("Invalid id_Role $id_Role");

        if( !isset($active) )
            $active = -1;
        $active = filter_var($active, FILTER_VALIDATE_INT, $options);
        if( null === $active )
            throw new Exception("Invalid active $active");

        if( !isset($username) )
            $username = -1;
        $username = filter_var($username, FILTER_SANITIZE_STRING,
                array(FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH));
        if( null === $username )
            throw new Exception("Invalid username $username");
        if( strlen($username) > 16 )
            throw new Exception("Invalid username length $username");
        return $this->db->getUsers($limit, $offset, $id_User, $id_Role, $active,
                $username);
    }

    public function get( $id ) {
        /*
         * 
         * id,  the id of the user
         * 
         */
        //TODO: validate that user can see user, wil need user id from auth

        $id = (int) $id;
        if( $id && $id > 0 )
            return $this->db->getUser($id);
        else
            throw new Exception("No id supplied");
    }

    public function add( $username, $password, $id_Role, $id_User ) {

        //TODO: validate that user can add users, wil need user id from auth
        //validate username
        if( !isset($username) )
            throw new Exception("No username supplied");
        $username = filter_var($username, FILTER_SANITIZE_STRING,
                array(FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH));
        if( null === $username )
            throw new Exception("Invalid username $username");
        if( strlen($username) < 2 || strlen($username) > 16 )
            throw new Exception("Invalid username length $username");

        //validate password
        if( !isset($password) )
            throw new Exception("No password supplied");
        $password = filter_var($password, FILTER_SANITIZE_STRING,
                array(FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH));
        if( null === $password )
            throw new Exception("Invalid password $password");
        if( strlen($password) < 6 || strlen($password) > 40 )
            throw new Exception("Invalid password length $username");


        //validate id_Role
        $id_Role = (int) $id_Role;
        if( !$id_Role )
            throw new Exception("Invalid id_Role $id_Role");
        if( $id_Role < 1 )
            throw new Exception("Invalid id_Role $id_Role");
        $id_Role = (int) $id_Role;
        $roledb = new Access_Model_DbTable_Role();
        try {
            $roledb->getRole($id_Role);
        } catch( Exception $exc ) {
            throw new Exception("Invalid id_Role $id_Role");
        }
        //TODO: validate that user can add new users with this role
        //validate id_User
        $id_User = (int) $id_User;
        if( !$id_User )
            throw new Exception("Invalid id_User $id_User");
        if( $id_User < 1 )
            throw new Exception("Invalid id_User $id_User");
        $userdb = new Access_Model_DbTable_User();
        try {
            $userdb->getUser($id_User);
        } catch( Exception $exc ) {
            throw new Exception("Invalid id_User $id_User");
        }
        //TODO: validate that user can add new users

        return $this->db->addUser($username, $password, 1, $id_Role, $id_User);
    }

    public function edit( $id, $username, $password, $active, $id_Role, $id_User ) {
        //TODO: validate that user can edit this users, look at the auth stuff

        $id = (int) $id;
        if( !$id ) {
            throw new Exception("Id is not provided.");
        }
        if( $id < 1 ) {
            throw new Exception("Id is invalid.");
        }


//        $active = (bool) $active;
        if( !isset($active) ) {
            throw new Exception("active not supplied.");
        }
        $active = (bool) $active;
        if( !is_bool($active) ) {
            throw new Exception("active not a bool.");
        }

        //validate username
        if( !isset($username) )
            throw new Exception("No username supplied");
        $username = filter_var($username, FILTER_SANITIZE_STRING,
                array(FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH));
        if( null === $username )
            throw new Exception("Invalid username $username");
        if( strlen($username) < 2 || strlen($username) > 16 )
            throw new Exception("Invalid username length $username");

        //validate password
        if( !isset($password) )
            throw new Exception("No password supplied");
        $username = filter_var($password, FILTER_SANITIZE_STRING,
                array(FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH));
        if( null === $password )
            throw new Exception("Invalid password $password");
        if( strlen($password) < 6 || strlen($password) > 40 )
            throw new Exception("Invalid password length $username");


        //validate id_Role
        $id_Role = (int) $id_Role;
        if( !$id_Role )
            throw new Exception("Invalid id_Role $id_Role");
        if( $id_Role < 1 )
            throw new Exception("Invalid id_Role $id_Role");
        $id_Role = (int) $id_Role;
        $roledb = new Access_Model_DbTable_Role();
        try {
            $roledb->getRole($id_Role);
        } catch( Exception $exc ) {
            throw new Exception("Invalid id_Role $id_Role");
        }
        //TODO: validate that user can edit this users with role
        //validate id_User
        $id_User = (int) $id_User;

        if( !$id_User )
            throw new Exception("Invalid id_User $id_User");
        if( $id_User < 1 )
            throw new Exception("Invalid id_User $id_User");
        $userdb = new Access_Model_DbTable_User();
        try {
            $userdb->getUser($id_User);
        } catch( Exception $exc ) {
            throw new Exception("Invalid id_User $id_User");
        }

        return $this->db->editUser($id, $username, $password, $active, $id_Role,
                $id_User, false);
    }

    public function delete( $id ) {
        //TODO: validate that user can delete this user, wil need user id from auth

        $id = (int) $id;
        if( !$id ) {
            throw new Exception("Id is not provided.");
        }
        if( $id < 1 ) {
            throw new Exception("Id is invalid.");
        }
        //TODO: validate that user can delete this person
        return $this->db->deleteUser($id);
    }

}

