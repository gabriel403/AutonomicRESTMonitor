<?php

class Access_Model_DbTable_User extends Zend_Db_Table_Abstract {

    protected $_name = 'User';

    public function getUsers( $limit, $offset, $id_User, $id_Role, $active,
            $username ) {

        $select = $this->select();

        $limit != -1 && $offset != -1 ? $select->limit($limit, $offset) : null;
//        $id_User != -1 ? $select->where("id_User = ?", $id_User) : null;
        $id_Role != -1 ? $select->where("id_Role = ?", $id_Role) : null;
        $active != -1 ? $select->where("active = ?", $active) : null;
        $username != -1 ? $select->where("username = ?", $username) : null;
        $result = $this->fetchAll($select);
        if( !$result )
            throw new Exception("Users not found.");

        $resultRay = $result->toArray();
        return $resultRay;
    }

    public function getUser( $id ) {

        //Create our select object and add the where condition based on the id supplied
        $select = $this->select();
        $select->where("id = ?", $id);

        //fetch the rsult of the query, check if there is a proper result object,
        // if not throw an exception
        $result = $this->fetchAll($select);
        if( !$result )
            throw new Exception("User-result not found.");

        //turn the result into an array of results,
        // if we don't have precisely 1 result throw an exception
        $resultRay = $result->toArray();
        if( count($resultRay) != 1 )
            throw new Exception("User not found");

        //return the first and only user in the resultRay
        return $resultRay[0];
    }

    public function addUser( $username, $password, $active, $id_Role, $id_User ) {

        $data = array(
            'username' => $username,
            'password' => SHA1($password . "sodiumchloride"),
            'active' => $active,
            'id_Role' => $id_Role,
            'id_User' => $id_User
        );
        return $this->insert($data);
    }

    public function editUser( $id, $username, $password, $active, $id_Role,
            $id_User ) {

        $data = array(
            'username' => $username,
            'password' => SHA1($password . "sodiumchloride"),
            'active' => $active,
            'id_Role' => $id_Role,
            'id_User' => $id_User
        );
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($data, $where);
    }

    public function deleteUser( $id ) {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->delete($where);
    }

}

