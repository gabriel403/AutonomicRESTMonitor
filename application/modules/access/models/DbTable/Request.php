<?php

class Access_Model_DbTable_Request extends Zend_Db_Table_Abstract {

	protected $_name = 'Request';

	public function gets($limit = 10, $offset = 0, $startStartTime = -1, $endStartTime = -1,
		$startResponseTime = -1, $endResponseTime = -1, $id_RequestType = -1, $id_Server = -1) {

		$select = $this->select();

		$limit != -1 && $offset != -1 ? $select->limit($limit, $offset) : null;
		$startStartTime != -1 ? $select->where("startTime >= ?", $startStartTime) : null;
		$endStartTime != -1 ? $select->where("startTime <= ?", $endStartTime) : null;
		$startResponseTime != -1 ? $select->where("responseTime >= ?", $startResponseTime) : null;
		$endResponseTime != -1 ? $select->where("responseTime <= ?", $endResponseTime) : null;
		$id_RequestType != -1 ? $select->where("id_RequestType = ?", $id_RequestType) : null;
		$id_Server != -1 ? $select->where("id_Server = ?", $id_Server) : null;

		$result = $this->fetchAll($select);
		if ( !$result )
			throw new Exception("No request types found.");

		$resultRay = $result->toArray();
		return $resultRay;
	}

	public function getRequest($id) {

		//Create our select object and add the where condition based on the id supplied
		$select = $this->select();
		$select->where("id = ?", $id);

		//fetch the rsult of the query, check if there is a proper result object,
		// if not throw an exception
		$result = $this->fetchAll($select);
		if ( !$result )
			throw new Exception("Type-result not found.");

		//turn the result into an array of results,
		// if we don't have precisely 1 result throw an exception
		$resultRay = $result->toArray();
		if ( count($resultRay) != 1 )
			throw new Exception("Type not found");

		//return the first and only site in the resultRay
		return $resultRay[0];
	}

	public function addRequest($startTime, $responseTime, $id_RequestType,
		$id_Server) {
		$startTime = date("Y-m-d H:i:s", $startTime);

		$data = array(
		    'startTime' => $startTime,
		    'responseTime' => $responseTime,
		    'id_RequestType' => $id_RequestType,
		    'id_Server' => $id_Server
		);
		return $this->insert($data);
	}

	public function editRequest($id, $startTime, $responseTime, $id_RequestType,
		$id_Server) {
		$startTime = date("Y-m-d H:i:s", $startTime);

		$data = array(
		    'startTime' => $startTime,
		    'responseTime' => $responseTime,
		    'id_RequestType' => $id_RequestType,
		    'id_Server' => $id_Server
		);
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		return $this->update($data, $where);
	}

	public function deleteRequest($id) {
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		return $this->delete($where);
	}

}

