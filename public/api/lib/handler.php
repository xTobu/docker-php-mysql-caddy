<?php
header('Content-Type: application/json; charset=utf-8');

if ($_ENV["DEPLOY"] == "dev") {
    // Cross-Origin Resource Sharing Header
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
}

class handler{  

    function setResponseCode($code, $reason = null) {
        $code = intval($code);
    
        if (version_compare(phpversion(), '5.4', '>') && is_null($reason))
            http_response_code($code);
        else
            header(trim("HTTP/1.0 $code $reason"));
    }

    function response( $status = 200, $data = null) {
        $this->setResponseCode($status);

        $res['status'] = $status;
        $res['data'] = $data;

        echo json_encode($res);

        return;
    }
}