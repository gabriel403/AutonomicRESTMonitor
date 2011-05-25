<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author gabriel
 */
class Default_Model_Acl extends Zend_Acl {

	public function __construct() {
// Add Resources
// Resource #1: Default Module
		$this->add(new Zend_Acl_Resource('default'));
// Resource #2: Admin Module
		$this->add(new Zend_Acl_Resource('admin'));

// Add Roles
// Role #1: User
		$this->addRole(new Zend_Acl_Role('user'));
// Role #2: Author (inherits from User)
		$this->addRole(new Zend_Acl_Role('admin'), 'user');

// Assign Access Rules
// Rule #1 & #2: User can access Default Module (Admin inherits this)
		$this->allow('user', 'default');
// Rule #3 & #4: Admin can access Admin Module (User denied by default)
		$this->allow('admin', 'admin');
	}

}

?>
