<?php

/**
 * Description of Head
 *
 * @author gabriel
 */
class Autonomic_Model_Monitoring_Head {

    function run( $host ) {
        if( function_exists('curl_init') ) {
            //echo "Can curl, so curling\r\n";
            return Autonomic_Model_Monitoring_CurlHead::run($host);
        } else {
            //echo "Can't curl. so headering\r\n";
            return Autonomic_Model_Monitoring_DefaultHead::run($host);
        }
    }

}

?>
