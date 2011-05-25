<?php

class Default_ViewController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		// action body
	}

	public function sitesAction() {

		$request = $this->getRequest();
		$dbm = new Access_Model_Site();
		if ( $request->isPost() ) {
			$hostname = $request->getParam("hostname");
			if ( strlen($hostname) == 0 )
				$hostname = -1;
			else
				$hostname = "%$hostname%";

			$ip = $request->getParam("ip");
			if ( strlen($ip) == 0 )
				$ip = -1;
			else
				$ip = "%$ip%";

			$active = $request->getParam("active");
			if ( strlen($active) == 0 )
				$active = -1;

			$id_User = $request->getParam("id_User");
			if ( strlen($id_User) == 0 )
				$id_User = -1;

			$limit = $request->getParam("limit");
			if ( strlen($limit) == 0 )
				$limit = 10;
			$offset = $request->getParam("offset");
			if ( strlen($offset) == 0 )
				$offset = 0;

			$result = $dbm->gets($limit, $offset, $hostname, $ip, $active, $id_User);
		}
		else
			$result = $dbm->gets();
		$result = array_values($result);
		$form = new Default_Form_genericViewForm($result, false);
		$this->view->form = $form;

		$dbm2 = new Access_Model_DbTable_Site();
		$result = $dbm2->info(Zend_Db_Table_Abstract::COLS);
		unset($result[0]);
		$result[] = "offset";
		$result[] = "limit";
		$searchform = new Default_Form_genericSearchForm($result);
		$searchform->populate($request->getParams());
		$this->view->searchform = $searchform;
	}

	public function requestsAction() {

		$request = $this->getRequest();
		$dbm = new Access_Model_DbTable_Request();
		if ( $request->isPost() ) {

			$startStartTime = $request->getParam("startStartTime");
			if ( strlen($startStartTime) == 0 )
				$startStartTime = -1;

			$endStartTime = $request->getParam("endStartTime");
			if ( strlen($endStartTime) == 0 )
				$endStartTime = -1;

			$startResponseTime = $request->getParam("startResponseTime");
			if ( strlen($startResponseTime) == 0 )
				$startResponseTime = -1;

			$endResponseTime = $request->getParam("endResponseTime");
			if ( strlen($endResponseTime) == 0 )
				$endResponseTime = -1;

			$id_RequestType = $request->getParam("id_RequestType");
			if ( strlen($id_RequestType) == 0 )
				$id_RequestType = -1;

			$id_Server = $request->getParam("id_Server");
			if ( strlen($id_Server) == 0 )
				$id_Server = -1;

			$limit = $request->getParam("limit");
			if ( strlen($limit) == 0 )
				$limit = 10;
			$offset = $request->getParam("offset");
			if ( strlen($offset) == 0 )
				$offset = 0;

			$result = $dbm->gets($limit, $offset, $startStartTime, $endStartTime,
					$startResponseTime, $endResponseTime, $id_RequestType, $id_Server);
		}
		else
			$result = $dbm->gets();
		$result = array_values($result);
		$form = new Default_Form_genericViewForm($result, false);
		$this->view->form = $form;

		$dbm2 = new Access_Model_DbTable_Site();
		$result = array("startStartTime", "endStartTime", "startResponseTime", "endResponseTime",
		    "id_RequestType", "id_Server", "offset", "limit");
		$searchform = new Default_Form_genericSearchForm($result);
		$searchform->populate($request->getParams());
		$this->view->searchform = $searchform;
	}

}

