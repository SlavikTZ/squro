<?php
error_reporting(E_ALL);
function getReferens($url){
    if(!(@$context = file_get_contents($url))){
        echo "error file";
        exit();
    }
    $absReferens = [];
    preg_match('~https?:\/\/[^\/]+)((\/[^\/]*)*)~si', $url, $match);
    $fullUrl = $match[0];
    $host = $match[1];
    $relativeUrl = preg_replace('~[^\/]+$~U', "" , $fullUrl);
    $pattern = "~<a.*href=[\"']?([^\"'>]+?)[\"']?.*>.*<[\\\s]*\/a\s*>~isU";
    preg_match_all($pattern, $context,$referens);
        foreach($referens[1] as &$ref){
            $ref = trim($ref);
            
            if(!preg_match('~https?|ftp:\/\/~', $ref)){
               switch (substr($ref, 0, 1)){
                   case "/":
                       if(substr($ref,1,1)==="/"){
                           $ref = "http:".$ref;
                       }else{
                           $ref = $host.$ref;
                       }
                       
                       break;
                   case "#":
                       $ref=$fullUrl;
                       break;
                   default:
                       if($ref="javascript:{};"){
                           $ref=$host;
                       }
                       $ref=$relativeUrl.$ref;
               }
            }
            if(!in_array($ref, $absReferens)){
                $absReferens[]=$ref;
            }
        }
        
            foreach($absReferens as $ref){
            echo $ref."\n";
        } 
        echo 'Count references:'. count($absReferens)."\n";
}
getReferens("$argv[1]");
//getReferens("https://www.yandex.ua/");
