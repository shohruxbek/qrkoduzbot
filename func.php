<?php

function qadam($a,$b){
    global $db;
    mysqli_query($db,"UPDATE `users` SET `qadam` = '$b' WHERE `chat_id` = '$a'");   
}
function rm(){
 global $db;
$sons = "SELECT COUNT(chat_id) FROM `users`";
$res = mysqli_query($db,$sons);
$son = mysqli_fetch_assoc($res);
$son = $son['COUNT(chat_id)'];

$jus = "SELECT COUNT(son) FROM `users` WHERE `son`=0";
$ress = mysqli_query($db,$jus);
$ju = mysqli_fetch_assoc($ress);
$ju = $ju['COUNT(son)'];
$to = round(($ju/$son)*100, 2);

$tr = "$son / $ju ✅ $to %";
return $tr;
}




function get($te,$chat_id){
    $gett = bot('getChatMember',['chat_id' =>"@$te",'user_id' => $chat_id]);
$gget = $gett->result->status;
return $gget;
}

function addban($a){
    global $db;
    if(is_numeric($a)){
        mysqli_query($db,"UPDATE `users` SET `status` = '0' WHERE `chat_id` = '$a'");
    }  
}
function dellban($a){
    global $db;
     if(is_numeric($a)){
    mysqli_query($db,"UPDATE `users` SET `status` = '1' WHERE `chat_id` = '$a'");   
}
}




?>