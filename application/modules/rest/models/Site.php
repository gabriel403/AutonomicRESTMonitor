<?php

class Rest_Model_Site {

    public function __construct() {
        $this->siteDb = new Access_Model_DbTable_Site();
    }

    public function getSites() {
        /*
         * 
         * valid query elements
         * hostname,    the possible hostname %hostname%
         * ip,          the possible IP %ip%
         * isActive,    wether the site is active or no, 1 or 0
         * addedBy,     the id_User or the person who added
         * 
         */
        return $this->siteDb->getSites();
    }

    public function getSite( $id ) {
        /*
         * 
         * id,  the id of the site
         * 
         */
        $id = (int) $id;
        if( $id && $id > 0 )
            return $this->siteDb->getSite($id);
        else
            throw new Exception("No id supplied");
    }

    public function addSite( $hostname, $ip, $id_User ) {

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
        
        return $this->siteDb->addSite($hostname, $ip, 1, $id_User);
    }
    
    public function editSite($id, $hostname, $ip, $active, $id_User) {

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
        $active = (bool) $active;
        if( !$active )
            throw new Exception("Invalid id_User $active");

        //validate id_User
        $id_User = (int) $id_User;
        if( !$id_User )
            throw new Exception("Invalid id_User $id_User");
        if( $id_User < 1 )
            throw new Exception("Invalid id_User $id_User");
        
        return $this->siteDb->editSite($id, $hostname, $ip, 1, $id_User);
        
    }

}

