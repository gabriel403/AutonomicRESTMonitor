<?php
class Autonomic_Controller_Plugin_RestAuth extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $username = $request->getHeader('username');
        $password = $request->getHeader('password');
        $auth = new Default_Model_Auth();
        if ( !$auth->authenticate($username,$password) ) {
            $this->getResponse()
                    ->setHttpResponseCode(403)
                    ->appendBody("Invalid API Key\n")
                    ;
            $request->setModuleName('default')
                        ->setControllerName('error')
                        ->setActionName('access')
                        ->setDispatched(true);

        }

    }

}
?>