<?php
/**
 * Description of DefaultHead
 *
 * @author gabriel
 */
class Autonomic_Model_Monitoring_DefaultHead {
    function run( $host ) {
        $start = microtime(true);
        $headers = @get_headers($host, 1);
        $finish = microtime(true);
        return isset($headers)?$finish-$start:false;
    }
    
    function test() {
        return self::run("http://google.co.uk");
    }
}

//var_export(Autonomic_Model_Monitoring_DefaultHead::test());

?>
