<?php
    $config = require_once __DIR__."/../../config.php";
    require_once __DIR__."/../../lib.php";
    
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,"https://discord.com/api/v10/guilds"); 
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array(
        "Authorization: Bot ".$config["token2"],
        "Content-type: application/json"
    ));
    $results =  curl_exec($ch);
    curl_close($ch);
    $guilds = json_decode($results,true);

    if(!isset($guilds["message"])){
    
        $res["success"] = true;
        $res["message"] = null;
        $res["data"] = $guilds
    }else{
        $res["success"] = false;
        $res["message"] = "Error";
        $res["data"] = null;
    }
    
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>