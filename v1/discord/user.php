<?php
    $config = require_once __DIR__."/../../config.php";
    require_once __DIR__."/../../lib.php";
    header("Content-Type: application/json; charset=UTF-8 access-control-allow-origin: *");
    
    if(isset($_GET["id"])){
        $id = htmlspecialchars($_GET["id"]);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"https://discord.com/api/v10/users/".$id); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            "Authorization: Bot ".$config["token"],
            "Content-type: application/json"
        ));
        $results =  curl_exec($ch);
        curl_close($ch);
        $user = json_decode($results,true);

        if(!isset($user["message"])){
            if(!is_null($user["avatar"])){
                $avatar = "https://cdn.discordapp.com/avatars/".$user["id"]."/".$user["avatar"].is_animated($user["avatar"])."?size=1024";
            }else{
                $avatar = null;
            }

            if(!is_null($user["banner"])){
                $banner = "https://cdn.discordapp.com/banners/".$user["id"]."/".$user["banner"].is_animated($user["banner"])."?size=1024";
            }else{
                $banner = null;
            }

            $res["success"] = true;
            $res["message"] = null;
            $res["data"] = (object)[
                "id"=> $user["id"],
                "username"=> $user["username"],
                "discriminator"=> $user["discriminator"],
                "tag"=> $user["username"]."#".$user["discriminator"],
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
        $res["message"] = "Parameter Not Found";
        $res["data"] = null;
    }
    
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>