<?php
    header("Content-Type: application/json; charset=UTF-8");
    
    if(isset($_GET["text"])&&isset($_GET["target"])){
        $source = htmlspecialchars($_GET["source"])||"auto";
        $target = htmlspecialchars($_GET["target"]);
        $text = htmlspecialchars($_GET["text"]);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,urlencode("https://translate.googleapis.com/translate_a/single?client=gtx&sl=".$source."&tl=".$target."&dt=t&dj=1&q=".$text)); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            "Content-type: application/json"
        ));
        $results =  curl_exec($ch);
        curl_close($ch);
        $translate = json_decode($results,true);

        $translated = array_map(function($sentence){
            return $sentence["trans"];
        },$translate["sentences"]);
        print($results);

        $res["success"] = true;
        $res["message"] = null;
        $res["data"] = (object)[
            "text"=> join("",$translated)
        ];
    }else{
        $res["success"] = false;
        $res["message"] = "Parameter Not Found";
        $res["data"] = null;
    }
    
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_UNESCAPED_UNICODE);
?>