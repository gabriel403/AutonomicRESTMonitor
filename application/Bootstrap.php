<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initRestRoute() {
        $this->bootstrap('frontController');
        $frontController = Zend_Controller_Front::getInstance();
        $restRoute = new Zend_Rest_Route($frontController, array(), array(
                    'rest',
                ));
        $frontController->getRouter()->addRoute('rest', $restRoute);
    }

    protected function _initActionHelpers() {
        $params = new Autonomic_Controller_Helper_Params();
        Zend_Controller_Action_HelperBroker::addHelper($params);

        $contexts = new Autonomic_Controller_Helper_RestContexts();
        Zend_Controller_Action_HelperBroker::addHelper($contexts);
    }

    protected function _initDoctype() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

}

