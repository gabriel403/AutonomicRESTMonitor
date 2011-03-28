<?php

class Access_Model_Requesttype {

    public function __construct() {
        $this->db = new Access_Model_DbTable_RequestType();
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
        //TODO: validate that user can see requesttypes, wil need user id from auth
        return $this->db->getTypes();
    }

    public function get( $id ) {
        /*
         * 
         * id,  the id of the site
         * 
         */
        //TODO: validate that user can see requesttypes, wil need user id from auth
        $id = (int) $id;
        if( $id && $id > 0 )
            return $this->db->getType($id);
        else
            throw new Exception("No id supplied");
    }

    public function add( $type, $id_User ) {
        //TODO: validate that user can add this requesttype, wil need user id from auth


        //validate type string
        if( !isset($type) )
            throw new Exception("Invalid type $type");
        $type = filter_var($type, FILTER_SANITIZE_STRING,
                array(FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH));
        if( null === $type )
            throw new Exception("Invalid type $type");
        if( strlen($type) > 64 )
            throw new Exception("Invalid type length $type");
        $type = ucfirst(strtolower($type));
        if( !class_exists("Autonomic_Model_Monitoring_$type") )
            throw new Exception("Type $type is not a valid monitoring type.");

 
        return $this->db->addType($type);
    }

    public function edit( $id, $type ) {
        //TODO: validate that user can edit this requesttype, wil need user id from auth

        //validate id provided
        $id = (int) $id;
        if( !$id ) {
            throw new Exception("Id is not provided.");
        }
        if( $id < 1 ) {
            throw new Exception("Id is invalid.");
        }

        //validate type string
        if( !is_string($type) )
            throw new Exception("Type $type is not a string");
        if( strlen($type) > 64 )
            throw new Exception("Type $type length greater than 64 characters.");

        if( !class_exists("Autonomic_Model_Monitoring_$type") )
            throw new Exception("Type $type is not a valid monitoring type.");

        return $this->db->editType($id, $type);
    }

    public function delete( $id ) {
        //TODO: validate that user can add this requestttype, wil need user id from auth

        $id = (int) $id;
        if( !$id ) {
            throw new Exception("Id is not provided.");
        }
        if( $id < 1 ) {
            throw new Exception("Id is invalid.");
        }

        return $this->db->deleteType($id);
    }

}

