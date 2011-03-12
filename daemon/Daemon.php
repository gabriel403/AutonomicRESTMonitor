<?php
$projectDir = "AutonomicRESTMonitor";
$workingDir = "/Applications/MAMP/htdocs/$projectDir/daemon/";
chdir($workingDir);
$fgc = file_get_contents("Monitoring.pid");
$command = 'ps -p ' . $fgc;
exec($command, $op);
if( count($op) == 1 )
    exec("nohup php Monitoring.php > Monitoring.log 2>&1 & echo $! > Monitoring.pid");
?>
