<?php

class Access_Model_DbTable_Role extends Zend_Db_Table_Abstract
{

    protected $_name = 'Role';

    public function getRoles() {

        $select = $this->select();
        
        $result = $this->fetchAll($select);
        if( !$result )
            throw new Exception("Roles not found.");
        
        $resultRay = $result->toArray();        
        return $resultRay;
    }

    public function getRole( $id ) {

        //Create our select object and add the where condition based on the id supplied
        $select = $this->select();
        $select->where("id = ?", $id);

        //fetch the rsult of the query, check if there is a proper result object,
        // if not throw an exception
        $result = $this->fetchAll($select);
        if( !$result )
            throw new Exception("Role-result not found.");

        //turn the result into an array of results,
        // if we don't have precisely 1 result throw an exception
        $resultRay = $result->toArray();
        if( count($resultRay) != 1 )
            throw new Exception("Role not found");

        //return the first and only site in the resultRay
        return $resultRay[0];
    }

    public function addRole($name, $canAddUser, $canDeleteUser,
                $canEditUser, $canAddRole, $canDeleteRole, $canEditRole,
                $canAddServer, $canDeleteServer, $canEditServer, $userLimit,
                $roleLimit, $serverLimit){
        
        $data = array(
            'name' => $name,
            'canAddUser' => $canAddUser,
            'canDeleteUser' => $canDeleteUser,
            'canEditUser' => $canEditUser,
            'canAddRole' => $canAddRole,
            'canDeleteRole' => $canDeleteRole,
            'canEditRole' => $canEditRole,
            'canAddServer' => $canAddServer,
            'canDeleteServer' => $canDeleteServer,
            'canEditServer' => $canEditServer,
            'userLimit' => $userLimit,
            'roleLimit' => $roleLimit,
            'serverLimit' => $serverLimit
        );
        return $this->insert($data);
    }

    public function editRole($id, $name, $canAddUser, $canDeleteUser,
                $canEditUser, $canAddRole, $canDeleteRole, $canEditRole,
                $canAddServer, $canDeleteServer, $canEditServer, $userLimit,
                $roleLimit, $serverLimit) {

        $data = array(
            'name' => $name,
            'canAddUser' => $canAddUser,
            'canDeleteUser' => $canDeleteUser,
            'canEditUser' => $canEditUser,
            'canAddRole' => $canAddRole,
            'canDeleteRole' => $canDeleteRole,
            'canEditRole' => $canEditRole,
            'canAddServer' => $canAddServer,
            'canDeleteServer' => $canDeleteServer,
            'canEditServer' => $canEditServer,
            'userLimit' => $userLimit,
            'roleLimit' => $roleLimit,
            'serverLimit' => $serverLimit
        );
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->update($data, $where);
    }

    public function deleteRole( $id ) {
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        return $this->delete($where);
    }

}

