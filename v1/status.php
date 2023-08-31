<?php
    require_once __DIR__."/../lib.php";
    
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    
    $data = db("SELECT * FROM log ORDER BY time ASC;")->fetchALL();

    $res["success"] = true;
    $res["message"] = null;
    $res["data"] = $data;

    $data = null;
    
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>