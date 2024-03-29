<?php
    class DB{
        private static $pdo = null;

        public static function connect(){
            if(self::$pdo === null){
                $config = require_once __DIR__ . "/config.php";
                self::$pdo = new PDO("mysql:host=".$config["db_host"].";dbname=".$config["db_name"].";charset=utf8mb4",$config["db_user"],$config["db_password"]);
            }
            return self::$pdo;
        }

        public static function query($query){
            $pdo = self::connect();
            $res = $pdo->query($query);
            return $res;
        }
    }

    function is_animated($image){
        $ext = substr($image,0,2);
        if($ext == "a_"){
            return ".gif";
        }else{
            return ".png";
        }
    }

    function Get($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = json_decode(curl_exec($ch));
        curl_close($ch);
        
        return $res;
    }

    function Post($url,$body){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($body));
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            "Content-type: application/json"
        ));
        $res = json_decode(curl_exec($ch),true);
        curl_close($ch);
        
        return $res;
    }
?>
