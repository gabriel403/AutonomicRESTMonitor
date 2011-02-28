<?php

class Rest_SiteController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->siteRest = new Rest_Model_Site();
    }

    public function indexAction() {
        //instantiate the rest version of the site model
        //do some sanity checking
        $error = array();

        try {
            $sites = $this->siteRest->getSites();
        } catch( Exception $exception ) {
            $error['code'] = 400;
            $error['message'] = $exc->getMessage();
        }

        if( count($error) > 0 )
            $this->getResponse()
                    ->setBody($error['message'])
                    ->setHttpResponseCode($error['code']);
        else
            $this->getResponse()
                    ->setBody(json_encode($sites))
                    ->setHttpResponseCode(200);
    }

    public function getAction() {
        //instance the rest version of the of the site model
        //inside of which we do some sanity work, don't neccasarily reply with all
        //instantiate the access site-db-model and run query
        //we only accept site.id
        //validation validation validation

        $id = $this->getRequest()->getParam("id");
        $error = array();

        try {
            $site = $this->siteRest->getSite($id);
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
                    ->setBody(json_encode($site))
                    ->setHttpResponseCode(200);
    }

    public function postAction() {

        $hostname = $this->getRequest()->getParam("hostname");
        $ip = $this->getRequest()->getParam("ip");
        $id_User = $this->getRequest()->getParam("id_User");
        $error = array();

        try {
            $id = $this->siteRest->addSite($hostname, $ip, $id_User);
        } catch( Exception $exc ) {
            $error['code'] = 400;
            $error['message'] = $exc->getMessage();
        }

        if( !$id || $id < 1 ) {

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
        
        parse_str(file_get_contents("php://input"), $vars);
        $this->getRequest()->setParams($vars);
        
        $id = $this->getRequest()->getParam("id");
        $hostname = $this->getRequest()->getParam("hostname");
        $ip = $this->getRequest()->getParam("ip");
        $active = $this->getRequest()->getParam("active");
        $id_User = $this->getRequest()->getParam("id_User");
        $error = array();

        try {
            $affected = $this->siteRest->editSite($id, $hostname, $ip, $active, $id_User);
        } catch( Exception $exc ) {
            $error['code'] = 400;
            $error['message'] = $exc->getMessage();
        }

        if( !$affected || $affected < 1 ) {

            $error['code'] = 404;
            $error['message'] = "failed to create";
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
            $deletesuccess = $this->siteRest->deleteUser($id);
        } catch( Exception $exc ) {
            $error['code'] = 400;
            $error['message'] = $exc->getMessage();
        }

        if( $deletesuccess < 1 ) {

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
