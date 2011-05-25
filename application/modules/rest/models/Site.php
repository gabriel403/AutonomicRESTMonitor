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

        //TODO: validate that user can view sites OR only list the sites the user has access

        return $this->db->getSites();
    }

    public function get( $id ) {
        /*
         * 
         * id,  the id of the site
         * 
         */
        $id = (int) $id;
        //TODO: validate that user can view this site
        //TODO: validate this shit more
        if( $id && $id > 0 )
            return $this->db->getSite($id);
        else
            throw new Exception("No id supplied");
    }

    public function add( $hostname, $ip, $id_User, $types = array() ) {
        //TODO: validate that user can add this site, wil need user id from auth
        //validate id_User
        $id_User = (int) $id_User;
        if( !$id_User )
            throw new Exception("Invalid id_User $id_User");
        if( $id_User < 1 )
            throw new Exception("Invalid id_User $id_User");
        //TODO: better validation
        //validate hostname
        if( !isset($hostname) )
            $hostname = null;
        $hostname = filter_var($hostname, FILTER_SANITIZE_STRING,
                array(FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH));
        if( null === $hostname )
            throw new Exception("Invalid hostname $hostname");
        if( strlen($hostname) > 64 )
            throw new Exception("Invalid hostname length $hostname");
        $validator = new Zend_Validate_Hostname();
        if( !$validator->isValid($hostname) )
            throw new Exception("Invalid hostname");


        //validate ip supplied $validator = new Zend_Validate_Ip()->isValid($ip);
        $ip = filter_var($ip, FILTER_SANITIZE_STRING,
                array(FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH));
        if( null === $ip )
            throw new Exception("Invalid ip $ip");
        $validator = new Zend_Validate_Ip();
        if( !$validator->isValid($ip) ) {
            if( strcasecmp($hostname, gethostbyname($hostname)) == 0 )
                throw new Exception("ip is not available, please set manually");
            else
                $ip = gethostbyname($hostname);
        }

        /*
         * Checking that the hostname provided can be pinged or headed
         */
        $requesttypedb = new Access_Model_DbTable_RequestType();
        $rt = $requesttypedb->getTypes();
        $skiped = array();
        $notskiped = array();
        $srt = new Access_Model_DbTable_SiteRequestType();
        foreach( $rt as $type ) {
            if( array_key_exists(strtolower($type['type']), $types) && 0 == $type['type'] ) {
                $skiped[] = $type['type'];
                continue;
            }
            $testtype = "Autonomic_Model_Monitoring_" . $type['type'];
            if( -1 == $testtype::run($hostname) )
                throw new Exception("The hostname provided is un-{$type['type']}able, if you still want to add this site, try adding types={\\\"{$type['type']}\\\":0}");
            $notskiped[] = $type['id'];
        }
        if( count($skiped) == count($rt) ) {
            $types = implode(", ", $skiped);
            throw new Exception("You can't try to add a site without allowing at least one of $types checking.");
        }

        /*
         * add the site to the db 
         */
        $id_Server = $this->db->addSite($hostname, $ip, 1, $id_User);


        /*
         * add the different requesttypes into the db per site
         */
        foreach( $notskiped as $type ) {
            $srt->insert(array("id_Server" => $id_Server, "id_Requesttype" => $type));
        }

        return $id_Server;
    }

    public function edit( $id, $hostname, $ip, $active, $id_User, $ping = 1,
            $head = 1 ) {
        //TODO: validate that user can edit this site, wil need user id from auth

        $id = (int) $id;
        if( !$id ) {
            throw new Exception("Id is not provided.");
        }
        if( $id < 1 ) {
            throw new Exception("Id is invalid.");
            //TODO: better validation
        }

        //validate hostname
        if( !is_string($hostname) )
            throw new Exception("Hostname is not a string");
        if( strlen($hostname) > 64 )
            throw new Exception("Hostname length greater than 64 characters.");
        $validator = new Zend_Validate_Hostname();
        if( !$validator->isValid($hostname) )
            throw new Exception("Invalid hostname");

        if( 1 == $ping && -1 == Autonomic_Model_Monitoring_Ping::run($hostname) )
            throw new Exception("The hostname provided is un-pingable, if you still want to add this site, try adding ping=0");
        if( 1 == $head && -1 == Autonomic_Model_Monitoring_Head::run($hostname) )
            throw new Exception("The hostname provided has no webservice running, if you still want to add this site, try adding head=0");
        //TODO: use the same stuff as in adding
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
        //TODO: better validation

        return $this->db->editSite($id, $hostname, $ip, $active, $id_User);
    }

    public function delete( $id ) {
        //TODO: validate that user can delete this site, wil need user id from auth

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

