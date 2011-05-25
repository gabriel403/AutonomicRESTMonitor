<?php

class Rest_SiteController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $this->RESTModel = new Access_Model_Site();
    }

    public function indexAction() {
        //instantiate the rest version of the site model
        //do some sanity checking
        $error = array();
        $id_User = Default_Model_Auth::getUserId();

        try {
            $allitems = $this->RESTModel->gets($id_User);
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
        //instance the rest version of the of the site model
        //inside of which we do some sanity work, don't neccasarily reply with all
        //instantiate the access site-db-model and run query
        //we only accept site.id
        //validation validation validation

        $id = $this->getRequest()->getParam("id");
        $id_User = Default_Model_Auth::getUserId();
        $error = array();

        try {
            $item = $this->RESTModel->get($id, $id_User);
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


        $hostname = $this->getRequest()->getParam("hostname");
        $ip = $this->getRequest()->getParam("ip");
        $types = $this->getRequest()->getParam("types");
        $types = (array)json_decode(stripslashes($types));
        $id_User = Default_Model_Auth::getUserId();
        $error = array();
        try {
            $id = $this->RESTModel->add($hostname, $ip, $id_User, $types);
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


        $id = $this->getRequest()->getParam("id");
        $hostname = $this->getRequest()->getParam("hostname");
        $ip = $this->getRequest()->getParam("ip");
        $active = $this->getRequest()->getParam("active");
        $id_User = $this->getRequest()->getParam("id_User");
        $error = array();

        try {
            $affected = $this->RESTModel->edit($id, $hostname, $ip, $active, $id_User);
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
        //instance the rest version of the of the site model
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
