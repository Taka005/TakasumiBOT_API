<?php
    require_once __DIR__."/../lib.php";

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    if(isset($_GET["id"])){
        $id = htmlspecialchars($_GET["id"]);

        $data = DB::query("SELECT * FROM history WHERE user = '".$id."';")->fetchALL();

        if($data){
            $res["success"] = true;
            $res["message"] = null;
            $res["data"] = $data[0];
        }else{
            $res["success"] = false;
            $res["message"] = "No History";
            $res["data"] = null;
        }
    }else{
        $res["success"] = false;
        $res["message"] = "UserId Not Found";
        $res["data"] = null;
    }

    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>