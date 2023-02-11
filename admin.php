<?php

if (!file_exists('channel.txt')) { 
 $myfile = fopen("channel.txt", "a");
 fclose($myfile);
}if (!file_exists('admin.txt')) { 
 $myfile = fopen("admin.txt", "a");
 fclose($myfile);
}
if(!file_exists('creator.txt')) { 
  $myfile = fopen("creator.txt", "a");
  fclose($myfile);
}


$adminlaar = explode("|", file_get_contents("admin.txt"));
$creator = file_get_contents("creator.txt");
if($chat_id){
    $adminqadam = file_get_contents("admin/".$chat_id."/qadam.txt");
}

$channels= file_get_contents("channel.txt");
$channel = explode("|", $channels);


if($text=="/id"){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Sizning id: $chat_id"
    ]);
    exit();
}

//---Bot creatorini ro'yxatdan o'tkazish

$key =json_encode([
    'keyboard'=>[
        [['text'=>"update->"],['text'=>"Reklama 💸"],['text'=>"⚖️ Statistika"]],
          [["text"=>"Ban berish 🚫"],["text"=>"✅ Bandan olish"]],
        [['text'=>"Admin qo'shish ➕"],['text'=>"➖ Adminni o'chirish"]],
        [['text'=>"Kanal qo'shish ➕"],['text'=>"➖ Kanalni o'chirish"]],
    ],
    'resize_keyboard'=>true
]);

if($text == "/mencreator" and $creator==""){
  file_put_contents("creator.txt", $chat_id);
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"{$chat_id} - {$firstname} - siz, creator bo'ldingiz",
    'reply_markup'=>$key
]);
  exit();
}elseif($text == "/mencreator" and $creator!=""){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz endi creator bo'lolmaysiz"
    ]);
    exit();
}

//----------------


if($chat_id==$creator or in_array($chat_id,$adminlaar)){





//Adminlar qadamlari uchun fayl hosil qilinyapdi
if($chat_id==$creator or in_array($chat_id,$adminlaar)){
   if(!file_exists("admin/".$chat_id)){
    mkdir("admin/".$chat_id);
} 
} 

/*$key =json_encode([
    'keyboard'=>[
        [['text'=>"Hisob to'ldirish"]],
        [['text'=>"update->"],['text'=>"Reklama 💸"],['text'=>"⚖️ Statistika"]],
          [["text"=>"Ban berish 🚫"],["text"=>"✅ Bandan olish"]],
        [['text'=>"Admin qo'shish ➕"],['text'=>"➖ Adminni o'chirish"]],
        [['text'=>"Kanal qo'shish ➕"],['text'=>"➖ Kanalni o'chirish"]],
        [['text'=>"Foydalanuvchi menyusi"]],
    ],
    'resize_keyboard'=>true
]);*/
//-------------

//---------

if($text=="Bekor qilish"){
 bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Tanlang",
    'reply_markup'=>$key
]);
 file_put_contents("admin/".$chat_id."/qadam.txt","adm");
 exit();
}






if($text=="admin" and $chat_id==$creator or $text=="admin" and in_array($chat_id,$adminlaar) or $text=="Admin" and $chat_id==$creator or $text=="Admin" and in_array($chat_id,$adminlaar)){
 bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"Tanlang",
    'reply_markup'=>$key,
]);
 file_put_contents("admin/".$chat_id."/qadam.txt","adm");
 exit();
}


//Reklama 💸 bo'limi
if($text=="update->" and $chat_id==$creator  or $text=="update->" and in_array($chat_id,$adminlaar)){
 bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"1ga oshirilyapdi",
]);
mysqli_query($db,"UPDATE `users` SET `son` = '1' WHERE `son` = 0");
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"tugadi",
]);
  exit();
}

$komp3 = "SELECT `chat_id` FROM `users`";
$ress3 = mysqli_query($db,$komp3);
$usersss= array();
while($rows3 = mysqli_fetch_assoc($ress3)){
    $usersss[] = $rows3['chat_id'];
}

$used = $usersss;
if($text=="Reklama 💸" and $chat_id==$creator or $text=="Reklama 💸" and in_array($chat_id,$adminlaar)){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Xabarni yuboring...\n\nXabaringiz  (text, rasm, video) bo'lishi kerak!",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"Bekor qilish"]],
            ]
        ])
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","rek");
    exit();
}


if($message and $chat_id==$creator and $adminqadam=="rek" or $message and in_array($chat_id,$adminlaar) and $adminqadam=="rek"){
    if($message->text){
        $rm = rm();

if($rm){}else{
    $rm="";
}
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"Yuborilmoqda...$rm",
             'reply_markup'=>json_encode([
            'remove_keyboard'=>true,
        ])
        ]);
        for($i=0;$i<count($used);$i++){

            $sqlqadam = "SELECT `son` FROM `users` WHERE `chat_id`={$used[$i]} AND `son`>0"; 
$resqadam= mysqli_query($db,$sqlqadam);
$rowqadam = mysqli_fetch_assoc($resqadam);
$dbson=$rowqadam['son'];

if($dbson>0){
    $s =  bot('sendMessage',[
                'chat_id'=>"{$used[$i]}",
                'text'=>$message->text
            ]);

    if($s){
           mysqli_query($db,"UPDATE `users` SET `son` = '0' WHERE `chat_id` = {$used[$i]}");
    }else{
        mysqli_query($db,"UPDATE `users` SET `son` = '-1' WHERE `chat_id` = {$used[$i]}");
    }
}
           
        }
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'text'=>"Yuborilib bo'ldi",
            'reply_markup'=>$key
        ]);
        file_put_contents("admin/".$chat_id."/qadam.txt","adm");
    }
    else if($message->photo){
        $rm = rm();

if($rm){}else{
    $rm="";
}
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"Yuborilmoqda...$rm"
        ]);

        for($i=0;$i<count($used);$i++){


            $sqlqadam = "SELECT `son` FROM `users` WHERE chat_id={$used[$i]}  AND `son`>0"; 
$resqadam= mysqli_query($db,$sqlqadam);
$rowqadam = mysqli_fetch_assoc($resqadam);
$dbson=$rowqadam['son'];

if($dbson>0){
    $s =    bot('sendPhoto',[
                'chat_id'=>"{$used[$i]}",
                'photo'=>$message->photo[0]->file_id,
                'caption'=>$message->caption
            ]);

    if($s){
           mysqli_query($db,"UPDATE `users` SET `son` = '0' WHERE `chat_id` = {$used[$i]}");
    }else{
        mysqli_query($db,"UPDATE `users` SET `son` = '-1' WHERE `chat_id` = {$used[$i]}");
    }
}



          
        }
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'text'=>"Yuborilib bo'ldi",
            'reply_markup'=>$key
        ]);
        file_put_contents("admin/".$chat_id."/qadam.txt","adm");
        
    }else if($message->video){
        $rm = rm();

if($rm){}else{
    $rm="";
}
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"Yuborilmoqda...$rm"
        ]);

        for($i=0;$i<count($used);$i++){

            $sqlqadam = "SELECT `son` FROM `users` WHERE chat_id={$used[$i]}  AND `son`>0"; 
$resqadam= mysqli_query($db,$sqlqadam);
$rowqadam = mysqli_fetch_assoc($resqadam);
$dbson=$rowqadam['son'];

if($dbson>0){
    $s =    bot('sendVideo',[
                'chat_id'=>"{$used[$i]}",
                'video'=>$message->video->file_id,
                'caption'=>$message->caption
            ]);

    if($s){
           mysqli_query($db,"UPDATE `users` SET `son` = '0' WHERE `chat_id` = {$used[$i]}");
    }else{
        mysqli_query($db,"UPDATE `users` SET `son` = '-1' WHERE `chat_id` = {$used[$i]}");
    }
}



            
        }
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'text'=>"Yuborilib bo'ldi",
            'reply_markup'=>$key
        ]);
        file_put_contents("admin/".$chat_id."/qadam.txt","adm");
        
    }else{
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'text'=>"Afsuski siz yuborgan narsani yubora olmayman!",
            'reply_markup'=>$key
        ]);
        file_put_contents("admin/".$chat_id."/qadam.txt","adm");
    }
    exit();
}

//-------


//⚖️ Statistika bo'limi

if(mb_stripos($text,"⚖️ Statistika") !== false and in_array($chat_id,$adminlaar) or mb_stripos($text,"⚖️ Statistika") !== false and $chat_id==$creator){

    $foyson = count($usersss);
    $admson = count($adminlaar)-1;
    $kanalson = count($channel)-1;
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'parse_mode'=>"Markdown",
        'text'=>"*Ushbu botda*:\n\n*Adminlar:* {$admson}ta\n*Foydalanuvchilar:* {$foyson}ta\n *Kanallar:* {$kanalson} ta"
    ]);
    exit();
}

//----------



//Yangi BAN tayinlash

if(mb_stripos($text,"Ban berish 🚫") !== false and in_array($chat_id,$adminlaar) or mb_stripos($text,"Ban berish 🚫") !== false and $chat_id==$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Kimni ban qilmoqchi bo'lsangiz o'shaning ID sini yuboring. Masalan: 438376242\n\n",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"Bekor qilish"]],
            ]
        ])
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","addban");

    exit();
}elseif(mb_stripos($text,"Ban berish 🚫") !== false and !in_array($chat_id,$adminlaar) or mb_stripos($text,"Ban berish 🚫") !== false and $chat_id!=$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz admin ham creator ham emassiz!"
    ]);exit();
}


if($message and in_array($chat_id,$adminlaar) and $adminqadam=="addban" or $message and $chat_id==$creator and $adminqadam=="addban"){
    addban($text);
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"{$text} - kishi; bannedlar ro'yxatiga qo'shildi",
        'reply_markup'=>$key
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","adm");
    exit();
}
//--------------------------












//BAN olish

if(mb_stripos($text,"✅ Bandan olish") !== false and in_array($chat_id,$adminlaar) or mb_stripos($text,"✅ Bandan olish") !== false and $chat_id==$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Kimni bandan olmoqchi bo'lsangiz o'shaning ID sini yuboring. Masalan: 438376242\n\n",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"Bekor qilish"]],
            ]
        ])
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","dellban");

    exit();
}elseif(mb_stripos($text,"✅ Bandan olish") !== false and !in_array($chat_id,$adminlaar) or mb_stripos($text,"✅ Bandan olish") !== false and $chat_id!=$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz admin ham creator ham emassiz!"
    ]);exit();
}


if($message and in_array($chat_id,$adminlaar) and $adminqadam=="dellban" or $message and $chat_id==$creator and $adminqadam=="dellban"){
    dellban($text);
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"{$text} - kishi; bannedlar ro'yxatidan olindi",
        'reply_markup'=>$key
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","adm");
    exit();
}
//--------------------------







//Yangi admin tayinlash

if(mb_stripos($text,"Admin qo'shish ➕") !== false and in_array($chat_id,$adminlaar) or mb_stripos($text,"Admin qo'shish ➕") !== false and $chat_id==$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Kimni admin qilmoqchi bo'lsangiz o'shaning ID sini yuboring. Masalan: 438376242\n\nAgar bilmasangiz o'sha kishi botga /id deb yozsin. Bot o'sha kishiga id raqamini yuboradi. keyin id raqamini sizga yuborsin.",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"Bekor qilish"]],
            ]
        ])
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","addadmin");

    exit();
}elseif(mb_stripos($text,"Admin qo'shish ➕") !== false and !in_array($chat_id,$adminlaar) or mb_stripos($text,"Admin qo'shish ➕") !== false and $chat_id!=$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz admin ham creator ham emassiz!"
    ]);exit();
}


if($message and in_array($chat_id,$adminlaar) and $adminqadam=="addadmin" or $message and $chat_id==$creator and $adminqadam=="addadmin"){
    $ref = file_get_contents("admin.txt");
    $ref.="{$text}|";
    file_put_contents("admin.txt", $ref);
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"{$text} - kishi; adminlar ro'yxatiga qo'shildi",
        'reply_markup'=>$key
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","adm");
    exit();
}
//--------------------------




//➖ Adminni o'chirish
if(mb_stripos($text,"➖ Adminni o'chirish") !== false and in_array($chat_id,$adminlaar) or mb_stripos($text,"➖ Adminni o'chirish") !== false and $chat_id==$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Kimni adminlikdan o'chirmoqchi bo'lsangiz o'shaning ID sini yuboring. Masalan: 438376242 \n\nAgar bilmasangiz o'sha kishi botga /id deb yozsin. Bot o'sha kishiga id raqamini yuboradi. keyin id raqamini sizga yuborsin.",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"Bekor qilish"]],
                [['text'=>"Hamma adminlarni o'chirish"]],
            ]
        ])
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","delladmin");
    exit();

}elseif(mb_stripos($text,"➖ Adminni o'chirish") !== false and !in_array($chat_id,$adminlaar) or mb_stripos($text,"➖ Adminni o'chirish") !== false and $chat_id!=$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz admin ham creator ham emassiz!"
    ]);exit();
}


if($message and in_array($chat_id,$adminlaar) and $adminqadam=="delladmin" or $message and $chat_id==$creator and $adminqadam=="delladmin"){
    if($text=="Hamma adminlarni o'chirish"){
      file_put_contents("admin.txt", "499816482|");
      bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Hamma adminlar ro'yxatdan o'chirildi",
        'reply_markup'=>$key
    ]);

  }else{
if($text!="499816482"){
    $ref = file_get_contents("admin.txt");
   $ref=str_replace("{$text}|", "", $ref);
   file_put_contents("admin.txt", $ref);
}
   bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"{$text} - kishi; adminlar ro'yxatidan o'chirildi",
    'reply_markup'=>$key
]);
}
file_put_contents("admin/".$chat_id."/qadam.txt","adm");
exit();
}


//------------------


//Yangi kanal tayinlash

if(mb_stripos($text,"Kanal qo'shish ➕") !== false and in_array($chat_id,$adminlaar) or mb_stripos($text,"Kanal qo'shish ➕") !== false and $chat_id==$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Qaysi kanalni qo'shmoqchi bo'lsangiz o'sha kanalni usernamesini jo'nating:\n\nmasalan: Yangiyilgaozqoldi\n\n @ - belgisi kerak emas!",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"Bekor qilish"]],
            ]
        ])
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","addkanal");

    exit();
}elseif(mb_stripos($text,"Kanal qo'shish ➕") !== false and !in_array($chat_id,$adminlaar) or mb_stripos($text,"Kanal qo'shish ➕") !== false and $chat_id!=$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz admin ham creator ham emassiz!"
    ]);exit();
}


if($message and in_array($chat_id,$adminlaar) and $adminqadam=="addkanal" or $message and $chat_id==$creator and $adminqadam=="addkanal"){
    $ref = file_get_contents("channel.txt");
    $ref.="{$text}|";
    file_put_contents("channel.txt", $ref);
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"{$text} - kanal; kanallar ro'yxatiga qo'shildi",
        'reply_markup'=>$key
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","adm");
    exit();
}
//--------------------------


//➖ Adminni o'chirish
if(mb_stripos($text,"➖ Kanalni o'chirish") !== false and in_array($chat_id,$adminlaar) or mb_stripos($text,"➖ Kanalni o'chirish") !== false and $chat_id==$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Qaysi kanalni o'chirmoqchi bo'lsangiz o'sha kanalni usernamesini jo'nating:\n\nmasalan: Yangiyilgaozqoldi\n\n @ - belgisi kerak emas!",
        'reply_markup'=>json_encode([
            'resize_keyboard'=>true,
            'keyboard'=>[
                [['text'=>"Bekor qilish"]],
                [['text'=>"Hamma kanallarni o'chirish"]],
            ]
        ])
    ]);
    file_put_contents("admin/".$chat_id."/qadam.txt","dellkanal");
    exit();

}elseif(mb_stripos($text,"➖ Kanalni o'chirish") !== false and !in_array($chat_id,$adminlaar) or mb_stripos($text,"➖ Kanalni o'chirish") !== false and $chat_id!=$creator){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Siz admin ham creator ham emassiz!"
    ]);exit();
}


if($message and in_array($chat_id,$adminlaar) and $adminqadam=="dellkanal" or $message and $chat_id==$creator and $adminqadam=="dellkanal"){
    if($text=="Hamma kanallarni o'chirish"){
      file_put_contents("channel.txt", "");
      bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"Hamma kanallar ro'yxatdan o'chirildi",
        'reply_markup'=>$key
    ]);

  }else{
   $ref = file_get_contents("channel.txt");
   $ref=str_replace("{$text}|", "", $ref);
   file_put_contents("channel.txt", $ref);
   bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"{$text} - kanal; kanallar ro'yxatidan o'chirildi",
    'reply_markup'=>$key
]);
}
file_put_contents("admin/".$chat_id."/qadam.txt","adm");
exit();
}

}
//------------------?>