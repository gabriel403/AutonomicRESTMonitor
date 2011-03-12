<?php

class Rest_Model_Site {

    public function __construct() {
        $this->db = new Access_Model_DbTable_Site();
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
        return $this->db->getSites();
    }

    public function get( $id ) {
        /*
         * 
         * id,  the id of the site
         * 
         */
        $id = (int) $id;
        if( $id && $id > 0 )
            return $this->db->getSite($id);
        else
            throw new Exception("No id supplied");
    }

    public function add( $hostname, $ip, $id_User ) {

        //validate hostname
        if( !is_string($hostname) )
            throw new Exception("Hostname is not a string");
        if( strlen($hostname) > 64 )
            throw new Exception("Hostname length greater than 64 characters.");
        $validator = new Zend_Validate_Hostname();
        if( !$validator->isValid($hostname) )
            throw new Exception("Invalid hostname");

        //validate ip supplied $validator = new Zend_Validate_Ip()->isValid($ip);
        $validator = new Zend_Validate_Ip();
        if( !$validator->isValid($ip) )
            throw new Exception("ip is not a string");

        //validate id_User
        $id_User = (int) $id_User;
        if( !$id_User )
            throw new Exception("Invalid id_User $id_User");
        if( $id_User < 1 )
            throw new Exception("Invalid id_User $id_User");
        
        return $this->db->addSite($hostname, $ip, 1, $id_User);
    }
    
    public function edit($id, $hostname, $ip, $active, $id_User) {

        $id = (int) $id;
        if( !$id ) {
            throw new Exception("Id is not provided.");
        }
        if( $id < 1 ) {
            throw new Exception("Id is invalid.");
        }
        
        //validate hostname
        if( !is_string($hostname) )
            throw new Exception("Hostname is not a string");
        if( strlen($hostname) > 64 )
            throw new Exception("Hostname length greater than 64 characters.");
        $validator = new Zend_Validate_Hostname();
        if( !$validator->isValid($hostname) )
            throw new Exception("Invalid hostname");

        //validate ip supplied $validator = new Zend_Validate_Ip()->isValid($ip);
        $validator = new Zend_Validate_Ip();
        if( !$validator->isValid($ip) )
            throw new Exception("ip is not a string");

        //validate active
        if( !isset($active) )
            throw new Exception("active not supplied");
        $active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
        if( !isset($active) )
            throw new Exception("Invalid active $active");

        //validate id_User
        $id_User = (int) $id_User;
        if( !$id_User )
            throw new Exception("Invalid id_User $id_User");
        if( $id_User < 1 )
            throw new Exception("Invalid id_User $id_User");
        
        return $this->db->editSite($id, $hostname, $ip, $active, $id_User);
        
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

        return $this->db->deleteSite($id);
    }

}

