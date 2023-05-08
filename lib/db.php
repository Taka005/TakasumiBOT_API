<?php
    $config = require_once __DIR__."/../config.php";

    function sql($query){
        $database = require_once __DIR__."/../database.php";
        $pdo = new PDO("mysql:host=".$config["db_host"].";dbname=".$config["db_name"].";charset=utf8",$config["db_user"],$config["db_password"]);
        return $pdo->query($query);
    }
?>