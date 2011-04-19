<?php

/**
 * Description of AuthController
 *
 * @author gabriel
 */
class Default_AuthController extends Zend_Controller_Action {

    public function authAction() {
        
        $form = new Default_Form_loginForm();
        $request = $this->getRequest();
        if( $request->isPost() ) {
            if( $form->isValid($request->getPost()) ) {
                echo "VALIDATED";
            }
            else
                echo "NOT VALIDATED";
        }
        exit;
    }

}

?>
