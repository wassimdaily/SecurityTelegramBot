<?php 
include 'connect.php';
ob_start();

$API_KEY = '665878730:AAFS7scOYqb1E5B3lLLPxRbuXU7JkkMKizM';  // API Token
define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
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


$update     = json_decode(file_get_contents('php://input'));
$message    = $update->message;
$text       = $message->text;
$chat_id    = $message->chat->id;
$first_name = $message->from->first_name;
$last_name  = $message->from->last_name;
$username   = $message->chat->username;
$usernameGroup = $message->from->username;
$id         = $message->from->id;
$msg_id     = $update->message->message_id;
$desc       = $message->chat->from->description;
$newMember  = $message->new_chat_member;
$groupTitle = $message->chat->title;
$checkBot   = $message->new_chat_member->is_bot;
$idBot   = $message->new_chat_member->id;
$frwaredMessage = $message->forward_from_chat;
$message->forward_from_chat->is_bot;

if ($checkBot == TRUE) {
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>'Spam bot has been deleted | سبام بوت تم حذفه بنجاح',
        'reply_to_message_id'=>$message->message_id
    ]);
    bot('KickChatMember',[
         'chat_id'=>$chat_id,
         'user_id'=>$idBot
     ]);

}

elseif( $newMember ){

 
        bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>$first_name .' '.$last_name."\n".' سعيدين بوجودك في قروب '."\n".' " '.$groupTitle.' " '."\n".' نتمنى لك التوفيق.',
        'reply_to_message_id'=>$message->message_id
    ]);

}



elseif($frwaredMessage and $message->forward_from_chat->is_bot == True){
    
        bot('deleteMessage',[
        'chat_id'=>$chat_id,
        'message_id'=>$msg_id
    ]);
    
        bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>'Spam fprwared message has been deleted',
        'reply_to_message_id'=>$message->message_id
    ]);
}

if($text == '/start'){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>'أهلا وسهلا'
        ]);
        
}