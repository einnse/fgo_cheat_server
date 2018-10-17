<?php

error_reporting(0);

$requestData = $_POST['requestData'];
$parts = explode("&",$requestData);
if( strpos($parts[3],"os=iOS")>0 ){
    $os = "ios";
}else{
    $os = "android";
}
$userId = substr($parts[12],7,12);

$db = dbopen();
$sql = "sql";
$result = dbquery();

if($result!=false){
    $config = dbfetch($result);
    $battlecancel = $config["battlecancel"];
}else{
    $config = false;
}
dbclose($db);

if($config && $battlecancel){

    $parts[11]= urldecode($parts[11]);
    $temp = substr($parts[11],7);
    $json=json_decode($temp);
    if($json->battleResult == 3){
        $json->battleResult = 1;
        $json->elapsedTurn = getElapsedTurn();
        $json->aliveUniqueIds = [];
        $temp=json_encode($json);
        $parts[11]= "result=".customUrlEncode($temp);
        $i=1;
        foreach($parts as $part){
            $newRequestData.=$part;
            if($i<sizeof($parts)){
                $newRequestData.='&';
            }
            ++$i;
        }
        unset($part);
        echo $newRequestData;
    }else{
        echo $requestData;
    }

}else{
    echo $requestData;
}

function customUrlEncode($string) {
    $entities = array('%22', '%27', '%3a', '%2c', '%5b', '%5d', '%7b', '%7d');
    $replacements = array('"', "'", ":", ",", "[", "]", "{", "}");
    return str_replace($replacements, $entities, $string);
}
