<?php
    $config = require_once __DIR__."/../../config.php";
    require_once __DIR__."/../../lib.php";
    
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    
    if(isset($_GET["id"])){
        $id = htmlspecialchars($_GET["id"]);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"https://discord.com/api/v10/users/".$id); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            "Authorization: Bot ".$config["token"],
            "Content-type: application/json"
        ));
        $user = json_decode(curl_exec($ch),true);
        curl_close($ch);

        if(!isset($user["message"])){
            $avatar = !is_null($user["avatar"])?"https://cdn.discordapp.com/avatars/".$user["id"]."/".$user["avatar"].is_animated($user["avatar"])."?size=1024" : null;
            $banner = !is_null($user["avatar"])?"https://cdn.discordapp.com/banners/".$user["id"]."/".$user["banner"].is_animated($user["banner"])."?size=1024" : null;

            $res["success"] = true;
            $res["message"] = null;
            $res["data"] = [
                "id"=> $user["id"],
                "username"=> $user["username"],
                "global_name"=> $user["global_name"],
                "discriminator"=> $user["discriminator"],
                "tag"=> $user["discriminator"] == 0?$user["username"] : $user["username"]."#".$user["discriminator"],
                "bot"=> !is_null($user["bot"])?true : false,
                "avatarURL"=> $avatar,
                "avatar"=> $user["avatar"],
                "bannerURL"=> $banner,
                "banner"=> $user["banner"],
                "bannerColor"=> $user["banner_color"],
                "accentColor"=> $user["accent_color"],
                "flag"=> $user["public_flags"]
            ];
        }else{
            $res["success"] = false;
            $res["message"] = "Unknown User";
            $res["data"] = null;
        }
    }else{
        $res["success"] = false;
        $res["message"] = "UserID Not Found";
        $res["data"] = null;
    }
    
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>