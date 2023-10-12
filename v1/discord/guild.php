<?php
    $config = require_once __DIR__."/../../config.php";
    require_once __DIR__."/../../lib.php";
    
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    
    if(isset($_GET["id"])){
        $id = htmlspecialchars($_GET["id"]);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"https://discord.com/api/v10/guilds/".$id."?with_counts=true"); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            "Authorization: Bot ".$config["token2"],
            "Content-type: application/json"
        ));

        $guild = json_decode(curl_exec($ch),true);
        curl_close($ch);

        if(!isset($guild["message"])){
            $icon = !is_null($guild["icon"])?"https://cdn.discordapp.com/icons/".$guild["id"]."/".$guild["icon"].is_animated($guild["icon"])."?size=1024" : null;

            $res["success"] = true;
            $res["message"] = null;
            $res["data"] = [
                "id"=> $guild["id"],
                "name"=> $guild["name"],
                "memberCount"=> $guild["approximate_member_count"],
                "onlineCount"=> $guild["approximate_presence_count"],
                "iconURL"=> $icon,
                "icon"=> $guild["icon"],
                "ownerId"=> $guild["owner_id"],
                "nitro"=> $guild["premium_subscription_count"]
            ];
        }else{
            $res["success"] = false;
            $res["message"] = "Unknown Guild";
            $res["data"] = null;
        }
    }else{
        $res["success"] = false;
        $res["message"] = "GuildID Not Found";
        $res["data"] = null;
    }
    
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>
