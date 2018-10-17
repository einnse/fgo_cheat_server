<?php

error_reporting(0);

$raw=$_POST['responseData'];
$rawBody=urldecode($raw);
$rawJsonStr=base64_decode($rawBody);
$rawJson=json_decode($rawJsonStr);
$json=$rawJson;

$userid=$rawJson->cache->replaced->battle[0]->userId;

if($json->cache->updated->userGame[0]->deviceinfo!=null){
    $device=$json->cache->updated->userGame[0]->deviceinfo;
}else{
    $device=$json->cache->replaced->userGame[0]->deviceinfo;
}

if(strpos($device, 'iOS') != FALSE){
    $os='ios';
}else{
    $os='android';
}

$db = dbopen();
$sql = "sql";
$result = dbquery();

if($result!=false){
    $config = dbfetch($result);
    $enabled = $config["enabled"];
    $uhp = $config["uhp"];
    $uatk = $config["uatk"];
    $tdlv = $config["tdlv"];
    $skilllv10 = $config["skilllv10"];
    $skillid1 = $config["skillid1"];
    $skillid2 = $config["skillid2"];
    $skillid3 = $config["skillid3"];
    $ehp = $config["ehp"];
    $eatk = $config["eatk"];
    $friendlyid = $config["friendlyid"];
    $equipid = $config["equipid"];
}else{
    echo $raw;
    dbclose($db);
    exit;
}

if(!$config){
    echo "no data";
}else{

    if($enabled){
        $Num=sizeof($rawJson->cache->replaced->battle[0]->battleInfo->userSvt);
        $friendNum=sizeof($rawJson->cache->replaced->battle[0]->battleInfo->myDeck->svts);
        $equipNum=sizeof($rawJson->cache->replaced->battle[0]->battleInfo->myUserSvtEquip);
        $enemyNum=0;
        $battleNum=sizeof($rawJson->cache->replaced->battle[0]->battleInfo->enemyDeck);
        $i=0;
        while($i<$battleNum){
            $enemyNum+=sizeof($rawJson->cache->replaced->battle[0]->battleInfo->enemyDeck[$i]->svts);
            ++$i;
        }
    
        $i=$friendNum+$equipNum;
        while($i<$Num){
            if($ehp>"0"){
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->hp=$ehp;
            }
            if($eatk>"0"){
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->atk=$eatk;
            }
            ++$i;
        }
    
        $i=0;
        while($i<$friendNum){

            if($uhp>"0"){
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->hp=$uhp;
            }
            if($uatk>"0"){
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->atk=$uatk;
            }
            if($tdlv>"0"){
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->treasureDeviceLv=$tdlv;
            }
            if($skilllv10){
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillLv1="10";
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillLv2="10";
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillLv3="10";
            }
            if($skillid1>"0"){
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillId1=$skillid1;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillLv1="10";
            }
            if($skillid2>"0"){
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillId2=$skillid2;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillLv2="10";
            }
            if($skillid3>"0"){
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillId3=$skillid3;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillLv3="10";
            }
    
            ++$i;
        }
    
        if($friendlyid!="0"){

            $sql = "sql";
            $result = dbquery();
            if($result!=false){
                $config = dbfetch($result);
                $friendly_svtid=$config["svtid"];
                $friendly_lv=$config["lv"];
                $friendly_limitCount=$config["limitcount"];
                $friendly_dispLimitCount=$config["displimitcount"];
                $friendly_commandCardLimitCount=$config["commandcardlimitcount"];
                $friendly_iconLimitCount=$config["iconlimitcount"];
                $friendly_portraitLimitCount=$config["portraitlimitcount"];
                $friendly_hp=$config["hp"];
                $friendly_atk=$config["atk"];
                $friendly_skillId1=$config["skillid1"];
                $friendly_skillId2=$config["skillid2"];
                $friendly_skillId3=$config["skillid3"];
                $friendly_skillLv1=$config["skilllv1"];
                $friendly_skillLv2=$config["skilllv2"];
                $friendly_skillLv3=$config["skilllv3"];
                $friendly_treasureDeviceId=$config["treasuredeviceid"];
                $friendly_treasureDeviceLv=$config["treasuredevicelv"];
                $friendly_individuality=$config["individuality"];
                $friendly_exceedCount=$config["exceedcount"];
                $friendly_classPassive=$config["classpassive"];
                $friendly_deathRate=$config["deathrate"];

                $friendly_individualitys=explode(",", $friendly_individuality);
                $friendly_individuality=[];
                foreach($friendly_individualitys as $val) {
                    array_push($friendly_individuality,$val); 
                }

                $friendly_classPassives=explode(",", $friendly_classPassive);
                $friendly_classPassive=[];
                foreach($friendly_classPassives as $val) {
                    array_push($friendly_classPassive,(int)$val); 
                }
            }

            if($config!=false){

                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->svtId=$friendly_svtid;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->lv=$friendly_lv;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->limitCount=$friendly_limitCount;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->dispLimitCount=$friendly_dispLimitCount;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->commandCardLimitCount=$friendly_commandCardLimitCount;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->iconLimitCount=$friendly_iconLimitCount;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->portraitLimitCount=$friendly_portraitLimitCount;
                if($uhp>"0"){
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->hp=$uhp;
                }else{
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->hp=$friendly_hp;
                }
                if($uatk>"0"){
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->atk=$uatk;
                }else{
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->atk=$friendly_atk;
                }
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillId1=$friendly_skillId1;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillId2=$friendly_skillId2;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillId3=$friendly_skillId3;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillLv1=$friendly_skillLv1;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillLv2=$friendly_skillLv2;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillLv3=$friendly_skillLv3;
                if($skillid1>"0"){
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillId1=$skillid1;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillLv1="10";
                }
                if($skillid2>"0"){
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillId2=$skillid2;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillLv2="10";
                }
                if($skillid3>"0"){
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillId3=$skillid3;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->skillLv3="10";
                }
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->treasureDeviceId=$friendly_treasureDeviceId;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->treasureDeviceLv=$friendly_treasureDeviceLv;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->individuality=$friendly_individuality;
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->exceedCount=$friendly_exceedCount;        
                if(sizeof($friendly_classPassives)>0){
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->classPassive=$friendly_classPassive;
                }else{
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->classPassive=[];
                }
                $json->cache->replaced->battle[0]->battleInfo->userSvt[0]->deathRate=$friendly_deathRate;

            }
        }

        if($equipid!="0"){

            $sql = "sql";
            $result = dbquery();
            if($result!=false){
                $config = dbfetch($result);
                $equip_svtid=$config["svtid"];
                $equip_lv=$config["lv"];
                $equip_limitCount=$config["limitcount"];
                $equip_dispLimitCount=$config["displimitcount"];
                $equip_hp=$config["hp"];
                $equip_atk=$config["atk"];
                $equip_skillId1=$config["skillid1"];
                $equip_skillLv1=$config["skilllv1"];
                $equip_svtIndividuality=$config["svtindividuality"];

                $equip_svtIndividualitys=explode(",", $equip_svtIndividuality);
                $equip_svtIndividuality=[];
                foreach($equip_svtIndividualitys as $val) {
                    array_push($equip_svtIndividuality,$val);
                }

            }

            if($config!=false){

                $i=$friendNum;

                while($i<($friendNum+$equipNum)){
                    $equip_dispLimitCount=$config["displimitcount"];
                    $equip_hp=$config["hp"];
                    $equip_atk=$config["atk"];
                    $equip_skillId1=$config["skillid1"];
                    $equip_skillLv1=$config["skilllv1"];
                    $equip_svtIndividuality=$config["svtindividuality"];
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->svtId=$equip_svtid;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->lv=$equip_lv;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->limitCount=$equip_limitCount;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->dispLimitCount=$equip_dispLimitCount;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->hp=$equip_hp;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->atk=$equip_atk;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillId1=$equip_skillId1;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->skillLv1=$equip_skillLv1;
                    $json->cache->replaced->battle[0]->battleInfo->userSvt[$i]->svtIndividuality=$equip_svtIndividuality;
                    ++$i;
                }

            }
        }
    
        $array = array(
            "response" => $json->response,
            "cache" => $json->cache,
            "sign" => getDataSign()
        );
    
        $newJsonStr = json_encode($array);
        $newBody = urlencode(base64_encode($newJsonStr));
        echo $newBody;
    
    }else{
        echo $raw;
    }

}

dbclose($db);
