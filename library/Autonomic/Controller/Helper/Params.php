<?php

class Autonomic_Controller_Helper_Params extends Zend_Controller_Action_Helper_Abstract {

    /**
     * @var array Parameters detected in raw content body
     */
    protected $_bodyParams = array();

    /**
     * Do detection of content type, and retrieve parameters from raw body if 
     * present
     * 
     * @return void
     */
    public function init() {
        $request = $this->getRequest();
        $contentType = $request->getHeader('Content-Type');
        $rawBody = $request->getRawBody();
        if( !$rawBody ) {
            return;
        }
        switch( true ) {
            case (strstr($contentType, 'application/json')):
                try {
                    $params = Zend_Json::decode($rawBody);
                    $request->setParams($params);
                } catch( Exception $exc ) {
                    $this->getResponse()->setHttpResponseCode(500)
                            ->setBody("Error in content type. You specified $contentType but did not supply it")
                            ->sendResponse();
                    exit;
                }

                break;
            case (strstr($contentType, 'application/xml')):

                try {

                    $config = new Zend_Config_Xml($rawBody);
                    $params = $config->toArray();
                    $request->setParams($params);
                } catch( Exception $exc ) {
                    $this->getResponse()->setHttpResponseCode(500)
                            ->setBody("Error in content type. You specified $contentType but did not supply it")
                            ->sendResponse();
                    exit;
                }


                break;
            case (strstr($contentType, 'application/x-www-form-urlencoded')):
                parse_str($rawBody, $params);
                $request->setParams($params);

                break;
            
            default:
                parse_str($rawBody, $params);
                $request->setParams($params);

                break;
        }
    }
}