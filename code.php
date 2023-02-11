<?php
define('API_KEY','#');
//echo "https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME'];
include ("db.php");
include "qrlib.php"; 
require "./vendor/autoload.php";

use Zxing\QrReader;   
function bot($method,$datas=[]){
    $url = "https://api.Telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$message_id = $message->message_id;
$chat_id = $message->chat->id;
$text = $message->text;

$callback = $update->callback_query;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id2 = $callback->message->message_id;
$data = $update->callback_query->data;

$callback = $update->callback_query;
$data = $update->callback_query->data;
$firstname = $message->from->first_name;
if($chat_id){
    if($message->chat->type!="private"){
    bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"Bot lichkasiga yozing: @qrkoduzbot"
    ]);
    exit();
}
}
if(!$chat_id){
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $callback->message->message_id;
}
$cqid = $update->callback_query->id;


$menu = json_encode([
    'resize_keyboard'=>true,
    "keyboard"=>[
        [["text"=>"🏁 QR kod yasash"]],
        [["text"=>"👁‍🗨 QR kod o'qish"]],
    ]
]);

$menu1 = json_encode([
    'resize_keyboard'=>true,
    "keyboard"=>[
        [["text"=>"Ortga"]],
    ]
]);






/*if($update){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>json_encode($update)
    ]);
}*/



include ("func.php");



if($chat_id){
    $sqlqadam = "SELECT * FROM `users` WHERE chat_id=$chat_id"; 
    $resqadam= mysqli_query($db,$sqlqadam);
    $rowqadam = mysqli_fetch_assoc($resqadam);

    if($rowqadam==null){
       mysqli_query($db,"INSERT INTO `users` (`id`, `chat_id`, `qadam`, `status`, `son`) VALUES (NULL, '$chat_id', 'bm', '1','0')");
       $qadam = "bm";
       $status = 1;
       $son = 0;
   }else{
    $qadam=$rowqadam['qadam'];
    $status=$rowqadam['status'];
    $son=$rowqadam['son'];
}
}



if($status==0){
  bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz ban qilingansiz!!!",
    ]); 
    exit(); 
}



include ("admin.php");





$cha = [];
$d = 0;

for($c=0;$c<count($channel)-1;$c++){

    $gget= get($channel[$c],$chat_id);


    if($gget != "member" and $gget != "creator" and $gget != "administrator"){
        $d++;
        array_push($cha,"1");
    }else{
        array_push($cha,"0");
    }
}


if($d==0){







if($text=="/start"){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Assalomu alaykum",
        'reply_markup'=>$menu
    ]);

    exit();
}





//http://phpqrcode.sourceforge.net/examples/index.php
if($text=="🏁 QR kod yasash"){
    qadam($chat_id,"qy");
 

      bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"So'z yuboring",
           'reply_markup'=>$menu1
    ]);

    exit();
}

if($text and $qadam=="qy" and $text!="Ortga"){
   $er = htmlspecialchars($text);
$id = "a{$chat_id}a";
    $rea = bot('sendphoto',[
        'chat_id'=>$chat_id,
        'photo'=>"https://[KOD TURGAN SAYT PAPKASI]/index.php?text=$er&id=$id",
        'reply_markup'=>$menu1
    ])->result;

if($rea==null){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz yuborgan matnda notanish belgi bor, boshqa matn yuboring",
        'reply_markup'=>$menu1
    ]);
}
     
    exit();
}




if($text=="Ortga"){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Tanlang...",
         'reply_markup'=>$menu
    ]);
qadam($chat_id,"bm");
    exit();
}



if($text=="👁‍🗨 QR kod o'qish"){
    qadam($chat_id,"qt");
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Rasm yuboring",
        'reply_markup'=>$menu1
    ]);

    exit();
}

if($message->photo and $qadam=="qt"){

  $doc_id = $message->photo;

  $d = count($doc_id)-1;

  $doc_id = $doc_id[$d]->file_id; 
$url = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getFile?file_id=".$doc_id),true);
$path = $url["result"]["file_path"];
$file = "https://api.telegram.org/file/bot".API_KEY."/".$path;
$type = explode(".", $path);
$type = $type[1];
$yu = "$chat_id".time();
$ok = file_put_contents("images/$yu.$type",file_get_contents($file));
if($ok){
  $qrcode = new QrReader("images/$yu.$type");

$text = $qrcode->text();
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Matn: $text",
    ]);
unlink("images/$yu.$type");
    exit();  

}else{
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Rasmni yuklashda xatolik",
    ]);

    exit();
}







}







}else{




   $rt = json_encode($cha);


   $pav="";
   for($k=0;$k<count($cha);$k++){


    $chann =$channel[$k];

    $n=$k+1;
    if($k==0){

       if($cha[$k]=="1"){
           $pav="[{\"text\":\"$n - kanalga a\'zo bo\'ling\",\"url\":\"https://t.me/$chann\"}]"; 
       }
   }else{

       if($cha[$k]=="1"){
           $pav.=",[{\"text\":\"$n - kanalga a\'zo bo\'ling\",\"url\":\"https://t.me/$chann\"}]";
       }
   }
}

if(substr($pav, 0, 1)==","){//$firstCharacter = substr($string, 0, 1);
    $pav = ltrim($pav, ',');
    $pav = str_replace(",,", ",", $pav);
}
$men='{"inline_keyboard":['."$pav".']}'; 

bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Salom, kanalga a'zo bo'ling va /start buyrug'ini tanlang" ,
    'reply_markup'=>$men
]);
exit();
}



?>