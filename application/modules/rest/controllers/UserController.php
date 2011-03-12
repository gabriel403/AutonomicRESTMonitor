<?php

class Rest_UserController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->RESTModel = new Rest_Model_User();
    }

    public function indexAction() {
        //instance the rest version of the user model
        //inside of which we do some sanity work, don't neccasarily reply with all
        //select the fields we want (just id and username?)
        //instantiate the access user-db-model and run query
        //we also have to think about queries supplied here
        //addedById=?, range=? etc
        //validation validation validation
        $error = array();
        
        try {
            $allitems = $this->RESTModel->gets();
        } catch( Exception $exc ) {
            $error['code'] = 400;
            $error['message'] = $exc->getMessage();
        }

        if( count($error) > 0 )
            $this->getResponse()
                    ->setBody($error['message'])
                    ->setHttpResponseCode($error['code']);
        else
            $this->getResponse()
                    ->setBody(json_encode($allitems))
                    ->setHttpResponseCode(200);
    }

    public function getAction() {
        //instance the rest version of the of the user model
        //inside of which we do some sanity work, don't neccasarily reply with all
        //instantiate the access user-db-model and run query
        //we only accept user.id
        //validation validation validation
        $id = $this->getRequest()->getParam("id");
        $error = array();
        
        try {
            $item = $this->RESTModel->get($id);
        } catch( Exception $exc ) {
            $error['code'] = 400;
            $error['message'] = $exc->getMessage();
        }
        
        if( count($error) > 0 )
            $this->getResponse()
                    ->setBody($error['message'])
                    ->setHttpResponseCode($error['code']);
        else
            $this->getResponse()
                    ->setBody(json_encode($item))
                    ->setHttpResponseCode(200);
    }

    public function postAction() {
        //instance the rest version of the of the user model
        //inside of which we do some sanity work, validate what is sent and that we have the right params etc
        //instantiate the access user-db-model and insert

        $username = $this->getRequest()->getParam("username");
        $password = $this->getRequest()->getParam("password");
        $id_Role = $this->getRequest()->getParam("id_Role");
        $id_User = $this->getRequest()->getParam("id_User");
        $error = array();
        
        try {
            $id = $this->RESTModel->add($username, $password, $id_Role, $id_User);
        } catch( Exception $exc ) {
            $error['code'] = 400;
            $error['message'] = $exc->getMessage();
        }

        if( count($error) < 1 && ( !$id || $id < 1) ) {

            $error['code'] = 404;
            $error['message'] = "failed to create";
        }
        
        if( count($error) > 0 )
            $this->getResponse()
                    ->setBody($error['message'])
                    ->setHttpResponseCode($error['code']);
        else {
            $location = array(
                $this->getRequest()->getModuleName(),
                $this->getRequest()->getControllerName(),
                $id);
            $location = implode("/", $location);

            $this->getResponse()
                    ->setHeader("Location", $location)
                    ->setHttpResponseCode(201);
        }
    }

    public function putAction() {
        //instance the rest version of the of the user model
        //inside of which we do some sanity work, validate the input
        //we accept the only stable field is User.id, this must be suppplied
        //instantiate the access user-db-model and update

        parse_str(file_get_contents("php://input"), $vars);
        $this->getRequest()->setParams($vars);

        $id         = $this->getRequest()->getParam("id");
        $username   = $this->getRequest()->getParam("username");
        $password   = $this->getRequest()->getParam("password");
        $active     = $this->getRequest()->getParam("active");
        $id_Role    = $this->getRequest()->getParam("id_Role");
        $id_User    = $this->getRequest()->getParam("id_User");
        $error      = array();
        
        try {
            $affected = $this->RESTModel->edit($id, $username, $password, $active, $id_Role, $id_User);
        } catch( Exception $exc ) {
            $error['code'] = 400;
            $error['message'] = $exc->getMessage();
        }

        if( count($error) < 1 && ( !isset($affected) || $affected < 1) ) {

            $error['code'] = 404;
            $error['message'] = "failed to edit";
        }
        
        if( count($error) > 0 )
            $this->getResponse()
                    ->setBody($error['message'])
                    ->setHttpResponseCode($error['code']);
    }

    public function deleteAction() {
        //instance the rest version of the of the user model
        //inside of which we do some sanity work, validate the user.id 
        //  and that the user can delete other users
        //instantiate the access user-db-model and delete
        $id = $this->getRequest()->getParam("id");
        $error = array();
        try {
            $deletesuccess = $this->RESTModel->delete($id);
        } catch( Exception $exc ) {
            $error['code'] = 400;
            $error['message'] = $exc->getMessage();
        }

        if( count($error) < 1 && (!isset($deletesuccess) || $deletesuccess < 1) ) {

            $error['code'] = 404;
            $error['message'] = "failed to delete";
        }

        if( count($error) > 0 )
            $this->getResponse()
                    ->setBody($error['message'])
                    ->setHttpResponseCode($error['code']);
        else
            $this->getResponse()
                    ->setHttpResponseCode(204);
    }

}
