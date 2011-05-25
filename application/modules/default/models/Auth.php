<?php

class Default_Model_Auth extends Zend_Db_Table_Abstract {

	public function getUserId() {
		$auth = Zend_Auth::getInstance();
		if ( $auth->hasIdentity() )
			return $auth->getIdentity()->id;
		return false;
	}
	
	public function getUserName() {
		$auth = Zend_Auth::getInstance();
		if ( $auth->hasIdentity() )
			return $auth->getIdentity()->username;
		return false;
	}

	public function authenticate($username, $password) {
		if ( !isset($username) || !isset($password) || strlen($username) < 3 || strlen($password) < 5 ) {
			return false;
		}
		return $this->_process(array('username' => $username, 'password' => $password));
	}

	protected function _process($values) {
		// Get our authentication adapter and check credentials
		$adapter = $this->_getAuthAdapter();
		$adapter->setIdentity($values['username']);
		$adapter->setCredential($values['password']);

		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($adapter);
		if ( $result->isValid() ) {
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
			->setCredentialTreatment("SHA1(CONCAT(?,'sodiumchloride'))");


		return $authAdapter;
	}

	public function userCanDosomething($userId, $dowhat, $towhat, $towhom = 0) {
		/* $dowhat can be add, edit, delete, get
		 *   add can be left totaly to this
		 *   edit need to check if the user owns the other user or is admin
		 *   delete and get don't do the initial check, but then
		 *    check if the user can touch the other user or is admin
		 */

		switch ( $towhat ) {
			case "role":
				return $this->isAdmin($userId);
				break;
			default:
				break;
		}
		switch ( $dowhat ) {
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

	public function isAdmin($userId) {

		/*
		 * select * from $towhat as towhat
		 * where towhat.id = $towhome
		 * join user on $towhat.id_User = user.id
		 * join role on user.id_Role = role.id
		 */
		$select = $this->getAdapter()->select()
			->from("User", 'id')
			->from("Role", '')
			->where("User.id = ?", $userId)
			->where("Role.id = User.id_Role")
			->where("Role.isAdmin = 1", $userId);
		$result = $this->getAdapter()->fetchAll($select);
		if ( !isset($result) )
			throw new Exception("Combo not found.");
		if ( count($result) != 1 )
			return false;
		return true;
	}

	public function checkOwnership($userId, $towhat, $towhom) {

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
		if ( !isset($result) )
			throw new Exception("Combo not found.");
		if ( count($result) != 1 )
			return false;
		return true;
	}

	public function addEditCheck($userId, $dowhat, $towhat) {
		$select = $this->getAdapter()->select()
			->from('User', '')
			->join('Role', 'Role.id = User.id_Role', array("limit" => "{$towhat}limit"))
			->where("can$dowhat$towhat = ?", 1)
			->where("User.id = ?", $userId);
		$result = $this->getAdapter()->fetchAll($select);
		if ( !isset($result) )
			throw new Exception("Combo not found.");
		if ( count($result) != 1 )
			return false;

		$limit = $result[0]['limit'];
		switch ( $limit ) {
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
		if ( !isset($result) )
			throw new Exception("Combo not found.");
		if ( count($result) != 1 )
			throw new Exception("Incorrect return count");

		$count = $result[0]['count'];
		if ( $limit - $count < 0 ) {
			//echo "User has too many $dowhat already. Hax";
			return false;
		} else if ( $limit - $count == 0 ) {
			//echo "User is on the limit of $dowhat they can add.";
			return false;
		} else if ( $limit - $count > 0 ) {
			//echo "User has room for more $dowhat.";
			return true;
		}
	}

}

