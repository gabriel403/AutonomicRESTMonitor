<?php

class Access_Model_DbTable_SiteRequestType extends Zend_Db_Table_Abstract
{

    protected $_name = 'SiteRequestType';
    
    public function get( $id_Requesttype, $id_Server ) {
        
        $select = $this->select();
        $select->where("id_Requesttype = ?", $id_Requesttype);
        $select->where("id_Server = ?", $id_Server);
        
        $result = $this->fetchAll($select);
        if( !$result )
            throw new Exception("Sites not found.");
        
        
        $resultRay = $result->toArray();
        return count($resultRay);
    }


}

