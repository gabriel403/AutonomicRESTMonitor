<?php

/**
 * Description of Ping
 *
 * @author gabriel
 */
class Autonomic_Model_Monitoring_Ping2 {

    function test() {
        return self::run("google.co.uk");
    }

    function run( $host ) {
        $package = "\x08\x00\x19\x2f\x00\x00\x00\x00\x70\x69\x6e\x67";

        /* create the socket, the last '1' denotes ICMP */
        $socket = socket_create(AF_INET, SOCK_RAW, 1);

        /* set socket receive timeout to 1 second */
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO,
                array("sec" => 1, "usec" => 0));

        /* connect to socket */
        socket_connect($socket, $host, null);

        /* record start time */
        $start_time = microtime(true);

        socket_send($socket, $package, strlen($package), 0);

        if( @socket_read($socket, 255) ) {
            $end_time = microtime(true);

            $total_time = $end_time - $start_time;

            $return = $total_time;
        } else {
            $return = -1;
        }

        socket_close($socket);

        return $return;
    }

}
