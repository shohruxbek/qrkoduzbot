<?php
define('API_KEY','1515288792:AAH5TZB13LTADJ9m_zSYjFoLHseEq72CIsg');
 //echo "https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME'];
include ("db.php");
include "qrlib.php";    
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
'text'=>"Bot lichkasiga yozing: @RasmkodBot"
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
        [["text"=>"♻️ QR kod yasash"]],
        [["text"=>"♻️ QR kod o'qish"]],
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
       $te =getToken(7);
       mysqli_query($db,"INSERT INTO `users` (`id`, `chat_id`, `qadam`, `status`) VALUES (NULL, '$chat_id', 'bm', '1')");
       $qadam = "bm";
       $status = 1;
   }else{
    $qadam=$rowqadam['qadam'];
    $status=$rowqadam['status'];
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










include ("sert.php");





if($text=="♻️ Hisobni to'ldirish"){
        bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"Variantlardan birini tanlang...",
        "parse_mode"=>"markdown",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🧨 Admin orqali"]],
[['text'=>"🌐 Referal orqali"]],
[['text'=>"Ortga"]],
]
        ])
    ]);
    qadam($chat_id,"ht");
    exit();
}

if($text=="🧨 Admin orqali" and $qadam=="ht"){
        bot("sendMessage",[
        "chat_id"=>$chat_id,
        'parse_mode'=>"markdown",
        "text"=>"Hozir siz admin orqali hisobni to'ldirishni tanladingiz.\n\n*Admin:* @Haqiqiy\_Matematik\n\n⚠️ Maqsadingiz aniq bo'lsa murojaat qiling!",
       'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"Bog'lanish",'url'=>"https://t.me/Haqiqiy_Matematik"]],
]
])
]);    
    exit();
}


if($text=="🌐 Referal orqali" and $qadam=='ht'){
    bot("sendPhoto",[
        "chat_id"=>$chat_id,
        "photo"=>"AgACAgEAAxkBAAPlYApnTnmsAAG0JsivPk8HgFOAN7XGAAJ7qTEbC3pQRGwzDvadQpuxC1_CShcAAwEAAwIAA3gAA7rVAAIeBA",
        "caption"=>"✅ <b>Sertifikatlar tizimining rasmiy boti</b> 🤖\n\n🎈 Do'stingizdan unikal havola-taklifnoma.\n\n👇 Tekin va sifatli Diplom uchun ko'k yozuvni ustiga bosing\n
        https://t.me/$botname?start=$token\n\nHar bir taklif qilgan do'stingizdan 1000 oling",
        "parse_mode"=>"html",
        "disable_web_page_preview"=>true,
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>' Do\'stlarga ulashish','url'=>"https://t.me/share/url?url=https%3A//t.me/$botname%3Fstart%3D$token&text=%0D%0A%F0%9F%98%8ABizning+botimizga+a%27zo+bo%27ling%F0%9F%98%8A%0D%0A%0D%0Ahttps%3A%2F%2Ft.me%2F$botname%3Fstart%3D$token%0D%0A%0D%0A%F0%9F%A4%B4%F0%9F%8F%BB%F0%9F%91%B8%F0%9F%8F%BB+Sizni+juda+ajoyib+sertifikatlar+kutmoqda.+Tepadagi+ko%27k+yozuvning+ustiga+bosing+va+ko%27plab+imkoniyatlarga+ega+bo%27ling."]]
            ]
        ]),
    ]);
    exit();
}

if($text=="💰 Hisobim"){
    bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"*Sizning hisobingizda:* $pul bor\n*Taklif qilgan do'stlaringiz:* $odam odam",
        "parse_mode"=>"markdown",
    ]);
    exit();
}

if($text=="👨‍💻 Dasturchi"){
    bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"*Telegram:* @ishonchingiz\n*Mobil:* +998995948233",
        "parse_mode"=>"markdown",
    ]);
    exit();
}

if($text=="🗒 Qo‘llanma"){
    bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"Siz berilgan bonuslar evaziga Diplom, Tashakkurnoma, sertifikat yoki Maqtov yorlig'i yasatib olsangiz bo'ladi. Hammasi \"Sertifikat yasash\" bo'limida bor\n\n To'liqroq ma'lumot: https://t.me/Rasmiy\_Sertifikat\_Bot\_Haqida",
        "parse_mode"=>"markdown",
    ]);
    exit();
}

if($text=="💌 Biz bilan aloqa"){
    bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"Takligingizni yozib yuboring...",
        "parse_mode"=>"markdown",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"Ortga"]]
]
        ])
    ]);
    qadam($chat_id,"ba");
    exit();
}

if($text and $qadam=="ba"){
$username = $message->from->username;//useradresi
$first_name = $message->from->first_name;//ismi
$last_name = $message->from->last_name;//ismi

$mid5=bot('ForwardMessage',[
        'chat_id'=> "$creator",
        'from_chat_id'=>$chat_id,
        'message_id'=>$message->message_id,
    ])->result->message_id;
    $mid=$message->message_id;

mid($chat_id,$mid5);

bot('sendMessage',[
       'chat_id'=> "$creator",
        'text'=> "*Id*: $chat_id
*Linki*: [ulanish](tg://user?id=$chat_id) 
*Ismi*: $first_name
*Familiyasi*: $last_name
*Usernamesi*: $username",
'reply_to_message_id'=>$mid5,
        'parse_mode'=>"markdown"
    ]);

 bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"Xabaringiz Administratorga yuborildi",
        "parse_mode"=>"markdown",
        'reply_markup'=>$menu
    ]);
    qadam($chat_id,"bm");
    exit();
}


$rchid=$message->reply_to_message->message_id;



if($message->reply_to_message->message_id and $chat_id == "$creator"){

//SELECT * FROM `users` WHERE `mid` = 0 LIMIT 1

 $sqlqadam = "SELECT * FROM `users` WHERE `mid` = '$rchid' LIMIT 1";
    $resqadam= mysqli_query($db,$sqlqadam);
    $rowqadam = mysqli_fetch_assoc($resqadam);
$chid = $rowqadam['chat_id'];



    bot('SendMessage',[
       'chat_id'=>$chid,
        'text'=>"$text",
    ]);
  $mid=$message->message_id;
    bot('SendMessage',[
       'chat_id'=> "$creator",
       'reply_to_message_id'=>$mid,
        'text'=> "Javob yuborildi",
    ]);
    exit();
}




if($text=="🏆 Reyting"){
$komps = "SELECT * FROM `users` ORDER BY `users`.`pul` DESC LIMIT 10";
$resss = mysqli_query($db,$komps);
$str = "";
$k=1;
while($rowss = mysqli_fetch_assoc($resss)){

    $id = $rowss['chat_id'];
    $pul = $rowss['pul'];

$str.="<b>{$k})</b> - <a href='tg://user?id=$id'>USER</a> - $id - <b>$pul</b> \n";
$k++;
}

//SELECT * FROM `users` ORDER BY `users`.`pul` DESC

$komps1 = "SELECT * FROM `users` ORDER BY `users`.`rasxod` DESC LIMIT 10";
$resss1 = mysqli_query($db,$komps1);
$str1 = "";
$k=1;
while($rowss1 = mysqli_fetch_assoc($resss1)){

    $id = $rowss1['chat_id'];
    $pul = $rowss1['rasxod'];

$str1.="<b>{$k})</b> - <a href='tg://user?id=$id'>USER</a> - $id - <b>$pul</b> \n";
$k++;
}


$komp2 = "SELECT * FROM `users` ORDER BY `users`.`sertsoni` DESC LIMIT 10";
$resss2 = mysqli_query($db,$komp2);
$str2 = "";
$k=1;
while($rowss2 = mysqli_fetch_assoc($resss2)){

    $id = $rowss2['chat_id'];
    $sertsoni = $rowss2['sertsoni'];

$str2.="<b>{$k})</b> - <a href='tg://user?id=$id'>USER</a> - $id - <b>$sertsoni</b> \n";
$k++;
}
    bot("sendMessage",[
        "chat_id"=>$chat_id,
        "text"=>"<b>Top 10talik obunachilar</b> (<i>Puli ko'plar</i>):\n$str\n\n<b>Top 10talik obunachilar</b> (<i>Ko'p pul ishlatganlar</i>):\n$str1\n\n<b>Top 10talik obunachilar</b> (<i>Sert ko'p yasaganlar</i>):\n$str2",
        "parse_mode"=>"html",
    ]);

exit();
}



}else{


    if($data=="tekshir"){
       bot('deleteMessage',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id
    ]);
       bot('answerCallbackQuery', ['callback_query_id' => $cqid, 'text' => "Kanalga a'zo bo'ling", 'show_alert' => false]);

   }


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
$pav.=",[{\"callback_data\":\"tekshir\",\"text\":\"Tekshirish\"}]";

if(substr($pav, 0, 1)==","){//$firstCharacter = substr($string, 0, 1);
    $pav = ltrim($pav, ',');
    $pav = str_replace(",,", ",", $pav);
}
$men='{"inline_keyboard":['."$pav".']}'; 

bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Salom, kanallarga a'zo bo'ling va A'zolikni tekshirish buyrug'ini tanlang" ,
    'reply_markup'=>$men
]);
exit();
}






if(mb_strpos($text, "start ")){
	$ref = explode(" ", $text);
	$t = $ref[1];
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Assalomu alaykum - Xush kelibsiz",
        'reply_markup'=>$menu
    ]);
    yangi($chat_id,$t);
    qadam($chat_id,"bm");
    if($bonus==1){
          bot('sendPhoto',[
            'chat_id'=>$chat_id,
            'photo'=>"AgACAgEAAxkBAAICa2AKh5E1FunqwIr59c5VqvbJIYuRAAIiqTEbSElZROxTlV_c4ldCb4fLShcAAwEAAwIAA3gAA3XRAAIeBA",
            'caption'=>"*Sizga bonus berildi:* +10000",
            "parse_mode"=>"markdown",
        ]);
        $pul+=10000;
        pul($chat_id,$pul); 
    } 
    exit();
}


?>