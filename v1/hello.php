<?php
    header("Content-Type: application/json; charset=UTF-8");
    
    $res["success"] = true;
    $res["message"] = null;
    $res["data"] = "Hello";
    
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>