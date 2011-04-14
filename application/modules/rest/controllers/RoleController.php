<?php

class Rest_RoleController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->RESTModel = new Access_Model_Role();
    }


    public function indexAction() {
        //instantiate the rest version of the site model
        //do some sanity checking
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
        //instance the rest version of the of the site model
        //inside of which we do some sanity work, don't neccasarily reply with all
        //instantiate the access site-db-model and run query
        //we only accept site.id
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

        $name = $this->getRequest()->getParam("name");
        $canAddUser = $this->getRequest()->getParam("canAddUser");
        $canDeleteUser = $this->getRequest()->getParam("canDeleteUser");
        $canEditUser = $this->getRequest()->getParam("canEditUser");
        $canAddRole = $this->getRequest()->getParam("canAddRole");
        $canDeleteRole = $this->getRequest()->getParam("canDeleteRole");
        $canEditRole = $this->getRequest()->getParam("canEditRole");
        $canAddSite = $this->getRequest()->getParam("canAddSite");
        $canDeleteSite = $this->getRequest()->getParam("canDeleteSite");
        $canEditSite = $this->getRequest()->getParam("canEditSite");
        $userLimit = $this->getRequest()->getParam("userLimit");
        $roleLimit = $this->getRequest()->getParam("roleLimit");
        $siteLimit = $this->getRequest()->getParam("siteLimit");
        $error = array();

        try {
            $id = $this->RESTModel->add($name, 
                    $canAddUser, $canDeleteUser, $canEditUser,
                    $canAddRole, $canDeleteRole, $canEditRole,
                    $canAddSite, $canDeleteSite, $canEditSite,
                    $userLimit, $roleLimit, $siteLimit);
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
        
        parse_str(file_get_contents("php://input"), $vars);
        $this->getRequest()->setParams($vars);
        
        $id = $this->getRequest()->getParam("id");
        $name = $this->getRequest()->getParam("name");
        $canAddUser = $this->getRequest()->getParam("canAddUser");
        $canDeleteUser = $this->getRequest()->getParam("canDeleteUser");
        $canEditUser = $this->getRequest()->getParam("canEditUser");
        $canAddRole = $this->getRequest()->getParam("canAddRole");
        $canDeleteRole = $this->getRequest()->getParam("canDeleteRole");
        $canEditRole = $this->getRequest()->getParam("canEditRole");
        $canAddSite = $this->getRequest()->getParam("canAddSite");
        $canDeleteSite = $this->getRequest()->getParam("canDeleteSite");
        $canEditSite = $this->getRequest()->getParam("canEditSite");
        $userLimit = $this->getRequest()->getParam("userLimit");
        $roleLimit = $this->getRequest()->getParam("roleLimit");
        $siteLimit = $this->getRequest()->getParam("siteLimit");
        $error = array();

        try {
            $affected = $this->RESTModel->edit($id, $name, 
                    $canAddUser, $canDeleteUser, $canEditUser,
                    $canAddRole, $canDeleteRole, $canEditRole,
                    $canAddSite, $canDeleteSite, $canEditSite,
                    $userLimit, $roleLimit, $siteLimit);
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
