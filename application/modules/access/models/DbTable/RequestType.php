<?php

class Access_Model_DbTable_RequestType extends Zend_Db_Table_Abstract
{

    protected $_name = 'RequestType';

    public function getTypes() {

        $select = $this->select();
        
        $result = $this->fetchAll($select);
        if( !$result )
            throw new Exception("No request types found.");
        
        $resultRay = $result->toArray();
        return $resultRay;
    }

    public function getType( $id ) {

        //Create our select object and add the where condition based on the id supplied
        $select = $this->select();
        $select->where("id = ?", $id);

        //fetch the rsult of the query, check if there is a proper result object,
        // if not throw an exception
        $result = $this->fetchAll($select);
        if( !$result )
            throw new Exception("Type-result not found.");

        //turn the result into an array of results,
        // if we don't have precisely 1 result throw an exception
        $resultRay = $result->toArray();
        if( count($resultRay) != 1 )
            throw new Exception("Type not found");

        //return the first and only site in the resultRay
        return $resultRay[0];
    }

    public function addType($type){
        
        $data = array(
            'type'  => $type
        );
        return $this->insert($data);
    }

    public function editType($id, $type ) {

        $data = array(
            'type' => $type
        );
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($data, $where);
    }

    public function deleteType( $id ) {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->delete($where);
    }
}

