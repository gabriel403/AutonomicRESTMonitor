<?php

require_once "../Model/Monitoring/Ping.php";
$ping = Autonomic_Model_Monitoring_Ping::factory();
if( PEAR::isError($ping) ) {
    echo "MOTHERFUCKINGERROR";
    echo $ping->getMessage();
} else {
    $ping->setArgs(array('count' => 6, 'ttl'=>1, 'timeout'=>10));
    var_dump($ping->ping('icheev.com'));
}
?>
