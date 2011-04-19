<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap {

    protected function _initView() {

        $view = new Zend_View();
        $view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
//        $view->dojo()->setLocalPath('/js/dojo/dojo/dojo.js')
//                ->addStylesheetModule('dijit.themes.soria');

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        return $view;
    }

}

