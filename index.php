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
    if($inline_data == 'eatAndFood'){
        $category = 'eatanddrink';
        $message = 'Категория - Еда и напитки';
        $button = location($category)[$buttons];
        editMassage($token,$inline_chat_id,$message_id,$message,$button);
    }
    sendMessage($token,$inline_chat_id,$inline_data);
    if($inline_data == 'entertainmentAndLaisure'){
        
    }
    
    if($inline_data == 'backToCategory'){
        $message = 'Категории';
        editMassage($token,$inline_chat_id,$message_id,$message,category());
    }
    
    
    
    
    
}

if ($text == "/start" ) {
    $reply = "Добро пожаловать в бота! Чтобы начать, отправь свою геолокацию!";
    $buttons = [[['text'=>"ОТПРАВИТЬ ГЕОЛОКАЦИЮ",'request_location'=>true]]];
    sendKeyboard($token,$chat_id,$buttons,$reply);   
}

if ($text == "Категории") {
    $reply = "Выберете категорию";
    inlineKeyboard($token,$chat_id,$reply,category());
}
function location($category){
    $near = array('text' => 'Ближайшие', 'callback_data' => 'near');
    $center = array('text' => 'Центр', 'callback_data' => 'center');
    $lenynsk = array('text' => 'Ленинский район', 'callback_data' => 'lenynsk');
    $backToCategory = array('text' => 'Назад', 'callback_data' => 'backToCategory');
    $buttons = [
         [$near],[$center],[$lenynsk],[$backToCategory]
    ];
    
    $param = [[$buttons],[$category]]
    return $param;
}

function category(){
    $eatAndFood = array('text' => 'Еда и напитки', 'callback_data' => 'eatAndFood');
    $entertainmentAndLaisure = array('text' => 'Развлечения и досуг', 'callback_data' => 'entertainmentAndLaisure');
    $healthAndBeauty = array('text' => 'Красота и здоровье', 'callback_data' => 'healthAndBeauty');
    $Delivery = array('text' => 'Доставка', 'callback_data' => 'Delivery');
    $Tourism = array('text' => 'Туризм', 'callback_data' => 'Tourism');
    $Gagets = array('text' => 'Гаджеты', 'callback_data' => 'Gagets');
    $buttons = [
        [$eatAndFood],[$entertainmentAndLaisure],[$healthAndBeauty],[$Delivery],[$Tourism],[$Gagets]
    ];
    return $buttons;
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
    $inlineKeyboard = json_encode(array("inline_keyboard" => $buttons),true);
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
