<?php
/**
 * Description of Head
 *
 * @author gabriel
 */
class Autonomic_Model_Monitoring_Head {
    function run( $host ) {
        if ( function_exists('curl_init') )
            return Autonomic_Model_Monitoring_CurlHead::run( $host );
        else
            return Autonomic_Model_Monitoring_DefaultHead::run( $host );
    }
}

?>
