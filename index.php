<?php
    
$token = "633839981:AAFtfuE_KVcHt1huA9RV6txQczt9It3xzI0";
$output = json_decode(file_get_contents('php://input'),true);

$inline_data = $output['callback_query']['data'];
$inline_chat_id = $output['callback_query']['message']['chat']['id'];
$message_id = $output['callback_query']['message']['message_id'];
$text = $output['message']['text'];
$chat_id = $output['message']['chat']['id'];

include 'distance.php';

if(isset($inline_data)){
    if($inline_data == 'next'){
        $message = 'NEXT';
        $button3 = array('text' => 'button3', 'callback_data' => 'but3');
        $button4 = array('text' => 'button4', 'callback_data' => 'but4');
        $next = array('text' => 'next', 'callback_data' => 'next');
        $prev = array('text' => 'prev', 'callback_data' => 'prev');
        $buttons = [
            [$button3],[$button4],
            [$next,$prev]
        ];
        editMassage($token,$inline_chat_id,$message_id,$message,$buttons);
    }
    if($inline_data == 'prev'){
        $message = 'PREV';
        $button1 = array('text' => 'button1', 'callback_data' => 'but1');
        $button2 = array('text' => 'button2', 'callback_data' => 'but2');
        $next = array('text' => 'next', 'callback_data' => 'next');
        $prev = array('text' => 'prev', 'callback_data' => 'prev');
        $buttons = [
            [$button1],[$button2],
            [$next,$prev]
        ];
        editMassage($token,$inline_chat_id,$message_id,$message,$buttons);
    }
}

if ($text == "/start" ) {
    $reply = "Добро пожаловать в бота! Чтобы начать, отправь свою геолокацию!";
    $buttons = [[['text'=>"ОТПРАВИТЬ ГЕОЛОКАЦИЮ",'request_location'=>true]]];
    sendKeyboard($token,$chat_id,$buttons,$reply);   
}

if ($text == "Инлайн Клавиатура") {
    $reply = "Вы выбрали 'Инлайн Клавиатура'";
    $button1 = array('text' => 'button1', 'callback_data' => 'but1');
    $button2 = array('text' => 'button2', 'callback_data' => 'but2');
    $next = array('text' => 'next', 'callback_data' => 'next');
    $prev = array('text' => 'prev', 'callback_data' => 'prev');
    $buttons = [
        [$button1],[$button2],
        [$next,$prev]
    ];
    inlineKeyboard($token,$chat_id,$reply,$buttons);
}

function sendMessage($token,$chat_id,$reply){
    $parameters = [
        'chat_id' => $chat_id, 
        'text' => $reply, 
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters));
}

function sendKeyboard($token,$chat_id,$buttons,$reply){
    $keyboard =  json_encode($keyboard = ['keyboard' => $buttons, 
                                          'resize_keyboard' => true, 
                                          'one_time_keyboard' => false, 
                                          'selective' => false]);  
    $parameters = [
        'chat_id' => $chat_id, 
        'text' => $reply, 
        'reply_markup' => $keyboard,
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters));
}

function inlineKeyboard($token,$chat_id,$reply,$buttons){
    
    $inlineKeyboard = array("inline_keyboard" => $buttons);
    $inlineKeyboard = json_encode($inlineKeyboard,true);
    $parameters = [
        'chat_id' => $chat_id, 
        'text' => $reply, 
        'reply_markup' => $inlineKeyboard,
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters));
}

function editMassage($token,$chat_id,$message_id,$message,$buttons){
    
    $inlineKeyboard = array("inline_keyboard" => $buttons);
    $inlineKeyboard = json_encode($inlineKeyboard,true);        
    $parameters = [
        'chat_id' => $chat_id, 
        'message_id' => $message_id, 
        'text' => $message,
        'reply_markup' => $inlineKeyboard,
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/editMessageText?' . http_build_query($parameters));
}
