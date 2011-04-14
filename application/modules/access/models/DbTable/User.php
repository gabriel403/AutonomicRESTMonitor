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

    public function userCanDosomething( $userId, $dowhat, $towhat, $towhom = 0 ) {
        /* $dowhat can be add, edit, delete, get
         *   add can be left totaly to this
         *   edit need to check if the user owns the other user or is admin
         *   delete and get don't do the initial check, but then
         *    check if the user can touch the other user or is admin
         */
        
        switch( $dowhat) {
            case "edit":
                if ( $this->addEditCheck($userId, $dowhat, $towhat) )
                    return $this->checkOwnership($userId, $towhat, $towhom);
                return false;
                break;
            case "add":
                return $this->addEditCheck($userId, $dowhat, $towhat);
                break;
            case "delete":
                return $this->checkOwnership($userId, $towhat, $towhom);
                break;
            case "get":
                return $this->checkOwnership($userId, $towhat, $towhom);
                break;

            default:
                break;
        }
    }

    public function checkOwnership($userId, $towhat, $towhom ) {
        
        /*
         * select * from $towhat as towhat
         * where towhat.id = $towhome
         * join user on $towhat.id_User = user.id
         * join role on user.id_Role = role.id
         */
        $towhat = ucfirst($towhat);
        
        $select = $this->getAdapter()->select()
                ->from(array("towhat" => $towhat), 'id')
                ->from("Role", '')
                ->from("User", '')
                ->where("towhat.id = ?", $towhom)
                ->where("User.id = ?", $userId)
                ->where("Role.id = User.id_Role")
                ->where("towhat.id_User = ? OR Role.isAdmin = 1", $userId);
        $result = $this->getAdapter()->fetchAll($select);
        if( !isset($result) )
            throw new Exception("Combo not found.");
        if( count($result) != 1 )
            return false;
        return true;
    }
    
    public function addEditCheck( $userId, $dowhat, $towhat ) {
        $select = $this->getAdapter()->select()
                ->from('User', '')
                ->join('Role', 'Role.id = User.id_Role',
                        array("limit" => "{$towhat}limit"))
                ->where("can$dowhat$towhat = ?", 1)
                ->where("User.id = ?", $userId);
        $result = $this->getAdapter()->fetchAll($select);
        if( !isset($result) )
            throw new Exception("Combo not found.");
        if( count($result) != 1 )
            return false;

        $limit = $result[0]['limit'];
        switch( $limit ) {
            case -1:
                //echo "User can add as many $dowhat as they want\n";
                return true;
                break;
            case 0:
                //echo "User can't add any $dowhat\n";
                return false;
                break;
            default:
                //echo "Dunno, let's check properly if they can add any more $dowhat\n";
                break;
        }
        //var_dump($result[0]);

        $select = $this->getAdapter()->select()
                ->from(ucfirst($towhat), array('count' => 'Count(*)'))
                ->where("id_User", $userId);
        $result = $this->getAdapter()->fetchAll($select);
        if( !isset($result) )
            throw new Exception("Combo not found.");
        if( count($result) != 1 )
            throw new Exception("Incorrect return count");

        $count = $result[0]['count'];
        if( $limit - $count < 0 ) {
            //echo "User has too many $dowhat already. Hax";
            return false;
        } else if( $limit - $count == 0 ) {
            //echo "User is on the limit of $dowhat they can add.";
            return false;
        } else if( $limit - $count > 0 ) {
            //echo "User has room for more $dowhat.";
            return true;
        }
    }

}

