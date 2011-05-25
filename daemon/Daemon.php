<?php
$projectDir = "AutonomicRESTMonitor";
$workingDir = "/var/www/$projectDir/daemon/";
chdir($workingDir);
$fgc = file_get_contents("Monitoring.pid");
if ( !isset($fgc) )
    throw new Exception( "Failed to open Monitoring.pid");
$command = 'ps -p ' . $fgc;
exec($command, $op);
if( count($op) == 1 )
    exec("nohup php Monitoring.php > Monitoring.log 2>&1 & echo $! > Monitoring.pid");
?>
