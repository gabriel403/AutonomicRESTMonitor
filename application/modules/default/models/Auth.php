<?php

class Default_Model_Auth {

   
    public function authenticate( $username, $password ) {
        if ( !isset($username) || !isset($password) || strlen($username) < 5 || strlen($password) < 5 ) {
            return false;
        }
        return $this->_process(array('username' => $username, 'password' => $password));
    }
    
    protected function _process( $values ) {
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if( $result->isValid() ) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }

    protected function _getAuthAdapter() {

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('User')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password')
                ->setCredentialTreatment('SHA1(CONCAT(?,salt))');


        return $authAdapter;
    }

}

