<?php
    require_once __DIR__."/../lib.php";

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $data = DB::query("SELECT name, COUNT(*) AS count FROM command GROUP BY name ORDER BY count DESC;")->fetchALL();

    $res["success"] = true;
    $res["message"] = null;
    $res["data"] = $data;

    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>