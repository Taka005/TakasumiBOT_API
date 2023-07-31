<?php
    $config = require_once __DIR__."/../../config.php";
    require_once __DIR__."/../../lib.php";
    
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $guilds = [];
    $after = null;

    do{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://discord.com/api/v10/users/@me/guilds");
        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
            "Authorization: Bot ".$config["token2"]
        ));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPGET,true);
        curl_setopt($ch,CURLOPT_GETFIELDS,http_build_query([
            "limit"=>200,
            "after"=>$after,
            "with_counts"=>true
        ]));

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        $guilds = array_merge($guilds, $data);
        $after = end($data)["id"] ?? null;
    }while(count($data) == 200);

    $res["success"] = true;
    $res["message"] = null;
    $res["data"] = array_map(function($guild){
        return (object)[
            $guild["id"]=>[$guild["name"],$guild["approximate_member_count"],$guild["approximate_presence_count"]]
        ];
    },$guilds);
  
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>