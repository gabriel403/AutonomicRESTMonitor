<?php

class Rest_Model_User {

    public function __construct() {
        $this->db = new Access_Model_DbTable_User();
    }

    public function gets() {
        /*
         * 
         * valid query elements
         * limit,   the limited range of elements returned
         * offset,  The number of elements to skip before we find values to return
         * addedBy, gets all the user with a specific id_User
         * role,    limits the result to those with the specified id_Role
         * active,  limits to wether the user is active
         * 
         */
        return $this->db->getUsers();
    }

    public function get( $id ) {
        /*
         * 
         * id,  the id of the user
         * 
         */
        $id = (int) $id;
        if( $id && $id > 0 )
            return $this->db->getUser($id);
        else
            throw new Exception("No id supplied");
    }

    public function add( $username, $password, $id_Role, $id_User ) {

        //validate username
        if( !is_string($username) ) 
            throw new Exception("Username not a string.");
        if( strlen($username) > 16 ) 
            throw new Exception("Username length greater than 16 characters.");

        //validate password
        if( !is_string($password) )
            throw new Exception("Password not a string.");
        if( strlen($password) > 40 )
            throw new Exception("Password length greater than 40 characters.");
        if( strlen($password) < 8 )
            throw new Exception("Password length less than 8 characters.");

        //validate id_Role
        $id_Role = (int) $id_Role;
        if( !$id_Role )
            throw new Exception("Invalid id_Role $id_Role");
        if( $id_Role < 1 )
            throw new Exception("Invalid id_Role $id_Role");
        $id_Role = (int) $id_Role;
        /***************
         * 
         * TODO: Need to validate if id_Role is a real role id before continuing
         * 
         */

        //validate id_User
        $id_User = (int) $id_User;
        if( !$id_User )
            throw new Exception("Invalid id_User $id_User");
        if( $id_User < 1 )
            throw new Exception("Invalid id_User $id_User");
        
        /***************
         * 
         * TODO: Need to validate if id_User is a real user id before continuing
         * 
         */

        return $this->db->addUser($username, $password, 1, $id_Role, $id_User);
    }

    public function edit( $id, $username, $password, $active, $id_Role, $id_User ) {

        $id = (int) $id;
        if( !$id ) {
            throw new Exception("Id is not provided.");
        }
        if( $id < 1 ) {
            throw new Exception("Id is invalid.");
        }


        //validate username
        if( !isset($username) ) {
            throw new Exception("Username not supplied.");
        }
        if( strlen($username) > 16 ) {
            throw new Exception("Username length greater than 16 characters.");
        }

        if( !isset($password) ) {
            throw new Exception("Password not supplied.");
        }
        if( !is_string($password) || strlen($password) == 0 )
            throw new Exception("Password not supplied.");
        if( strlen($password) > 40 ) {
            throw new Exception("Password length greater than 40 characters.");
        }
        if( strlen($password) < 8 ) {
            throw new Exception("Password length less than 8 characters.");
        }

//        $active = (bool) $active;
        if( !isset($active) ) {
            throw new Exception("active not supplied.");
        }
        $active = (bool) $active;
        if( !is_bool($active) ) {
            throw new Exception("active not a bool.");
        }

        /***************
         * 
         * TODO: Need to validate if id_Role is a real role id before continuing
         * 
         */
        //validate id_Role
        $id_Role = (int) $id_Role;
        if( !$id_Role )
            throw new Exception("id_Role not supplied.");
        if( $id_Role < 1 )
            throw new Exception("Invalid id_Role $id_Role");
        $id_Role = (int) $id_Role;

        /***************
         * 
         * TODO: Need to validate if id_User is a real user id before continuing
         * 
         */
        //validate id_User
        $id_User = (int) $id_User;
        if( !$id_User )
            throw new Exception("id_User not supplied.");
        if( $id_User < 1 )
            throw new Exception("Invalid id_User $id_User");

        return $this->db->editUser($id, $username, $password, $active, $id_Role, $id_User);
    }
    
    public function delete($id)
    {
     
        $id = (int) $id;
        if( !$id ) {
            throw new Exception("Id is not provided.");
        }
        if( $id < 1 ) {
            throw new Exception("Id is invalid.");
        }

        return $this->db->deleteUser($id);
    }

}

