<?php

require_once '../public/index.php';

$roledb = new Access_Model_DbTable_Role();
$requesttypesdb = new Access_Model_DbTable_RequestType();
$requestdb = new Access_Model_DbTable_Request();
$sitesdb = new Access_Model_DbTable_Site();

while( true ) {
    $sites = $sitesdb->getSites();
    $requesttypes = $requesttypesdb->getTypes();
    //$config = Zend_Registry::get('config');
    $maintime = 300;//$config->monitoring->maintimeS;

    $looptime = $maintime / count($sites);

    foreach( $sites as $site ) {
        echo "Starting site {$site['hostname']}\r\n";
        $loopStart = microtime(true);
        foreach( $requesttypes as $requesttype ) {
            echo "Starting type '{$requesttype['type']}'\r\n";
            $startTime = time();
            echo "Starting at $startTime\r\n";
            $type = "Autonomic_Model_Monitoring_" . $requesttype['type'];
            echo "Trying '$type::run({$site['hostname']})'\r\n";
            $time_taken = round($type::run($site['hostname']),3);
            echo "Time taken is '$time_taken'\r\n";
            $requestdb->addRequest($startTime, $time_taken, $requesttype['id'],
                    $site['id']);
            echo "insert completed, moving on\r\n";
        }
//        foreach( $requesttypes as $requesttype ) {
//            $type = "Autonomic_Model_Monitoring_".$requesttype['type'];
//            $time_taken = $type::run($site['ip']);
//            $requestdb->addRequest($startTime, $time_taken, $requesttype['id'], $site['id']);
//        }
        $loopFinish = microtime(true);
        $time_dif = round(($loopFinish - $loopStart) * 1000000);
        $time_mif = round($looptime * 1000000 - $time_dif);
        echo "Finished all requests for site {$site['hostname']}\r\n";
        echo "Sleeping for $time_mif microseconds\r\n\r\n";
        usleep($time_mif);
    }
}
?>
