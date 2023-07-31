<?php
    $config = require_once __DIR__."/../../config.php";
    require_once __DIR__."/../../lib.php";
    
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    
    $guilds = Post("https://api.gakerbot.net/guilds",array(
        "token"=>$config["token"]
    ));

    if($res["success"]){
        $res["success"] = true;
        $res["message"] = null;
        $res["data"] = [];

        foreach ($guilds as $guild) {
            $res["data"][$guild["id"]] = [
                "name" => $guild["name"],
                "memberCount" => $guild["approximate_member_count"],
                "presenceCount" => $guild["approximate_presence_count"]
            ];
        }
    }else{
        $res["success"] = false;
        $res["message"] = "Error";
        $res["data"] = null;
    }
    
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>