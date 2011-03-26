<?php

/**
 * Description of CurlHead
 *
 * @author gabriel
 */
class Autonomic_Model_Monitoring_CurlHead {

    function run( $host ) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $host);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $start = microtime(true);
        $header = curl_exec($curl);
        $finish = microtime(true);
        $header = http_parse_headers($header);
        curl_close($curl);
        return count($header) == 0?-1:$finish-$start;
    }

    function test() {
        return self::run("google.co.uk");
    }

}

function http_parse_headers( $header ) {
    $retVal = array();
    $fields = explode("\r\n",
            preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
    foreach( $fields as $field ) {
        if( preg_match('/([^:]+): (.+)/m', $field, $match) ) {
            $match[1] = preg_replace('/(?<=^|[\x09\x20\x2D])./e',
                    'strtoupper("\0")', strtolower(trim($match[1])));
            if( isset($retVal[$match[1]]) ) {
                $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
            } else {
                $retVal[$match[1]] = trim($match[2]);
            }
        }
    }
    return $retVal;
}

//var_dump(Autonomic_Model_Monitoring_CurlHead::test());
?>
