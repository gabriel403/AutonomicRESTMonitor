<?php

class Access_Model_DbTable_Site extends Zend_Db_Table_Abstract
{

    protected $_name = 'Site';

    public function getSites() {

        $select = $this->select();
        
        $result = $this->fetchAll($select);
        if( !$result )
            throw new Exception("Sites not found.");
        
        
        $resultRay = $result->toArray();
        return $resultRay;
    }

    public function getSite( $id ) {

        //Create our select object and add the where condition based on the id supplied
        $select = $this->select();
        $select->where("id = ?", $id);

        //fetch the rsult of the query, check if there is a proper result object,
        // if not throw an exception
        $result = $this->fetchAll($select);
        if( !$result )
            throw new Exception("Site-result not found.");

        //turn the result into an array of results,
        // if we don't have precisely 1 result throw an exception
        $resultRay = $result->toArray();
        if( count($resultRay) != 1 )
            throw new Exception("Site not found");

        //return the first and only site in the resultRay
        return $resultRay[0];
    }

    public function addSite($hostname, $ip, $active, $id_User){
        
        $data = array(
            'hostname'  => $hostname,
            'ip'        => $ip,
            'active'  => $active,
            'id_User'   => $id_User
        );
        return $this->insert($data);
    }

    public function editSite($id, $hostname, $ip, $active, $id_User ) {

        $data = array(
            'hostname'  => $hostname,
            'ip'        => $ip,
            'active'  => $active,
            'id_User'   => $id_User
        );
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($data, $where);
    }

    public function deleteSite( $id ) {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->delete($where);
    }

}

