<?php

class Rest_RequestController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->RESTModel = new Access_Model_Request();
    }

    public function indexAction()
    {
    }

    public function getAction()
    {
    }

    public function postAction()
    {
    }

    public function putAction()
    {
    }

    public function deleteAction()
    {
    }

}
