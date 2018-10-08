<?php
    
$token = "633839981:AAFtfuE_KVcHt1huA9RV6txQczt9It3xzI0";
$output = json_decode(file_get_contents('php://input'),true);

$text = $output['message']['text'];
$chat_id = $output['message']['chat']['id'];



if ($text == "/start" ) {
    $reply = "Добро пожаловать в бота!";
    $buttons = [["Еда и напитки"],["Инлайн Клавиатура"],["EDIT"]];
    sendKeyboard($token,$chat_id,$buttons);
    sendMessage($token,$chat_id,$reply);
}
if ($text == "Главное меню") {
    $reply = "Главное меню";
    $buttons = [["Еда и напитки"],["Инлайн Клавиатура"],["EDIT"]];
    sendKeyboard($token,$chat_id,$buttons);
    sendMessage($token,$chat_id,$reply);
}

if ($text == "Еда и напитки") {
    $reply = "Вы выбрали 'Еда и напитки'";
    $buttons = [["Кафе"],["Кофе"],["Ресторан"],["Главное меню"]];
    sendKeyboard($token,$chat_id,$buttons);
    sendMessage($token,$chat_id,$reply);
}
if ($text == "Инлайн Клавиатура") {
    $reply = "Вы выбрали 'Инлайн Клавиатура'";
    inlineKeyboard($token,$chat_id,$reply);
}
if ($text == "EDIT") {
    $reply = "Исправить";
    sendMessage($token,$chat_id,$reply);
}
function sendMessage($token,$chat_id,$reply){
    $parameters = [
        'chat_id' => $chat_id,
        'text' => $reply,  
    ];
    $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters);
    file_get_contents($url);
}
function sendKeyboard($token,$chat_id,$buttons){
    $keyboard =  json_encode($keyboard = ['keyboard' => $buttons, 
                                          'resize_keyboard' => false, 
                                          'one_time_keyboard' => false , 
                                          'selective' => false]);  
    $parameters = [
        'chat_id' => $chat_id, 
        'text' => '.', 
        'reply_markup' => $keyboard,
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters));
}
function inlineKeyboard($token,$chat_id,$reply){
    $button1 = array('text' => 'button1', 'callback_data' => 'Вы выбрали первую кнопку');
    $button2 = array('text' => 'button2', 'callback_data' => 'Вы выбрали вторую кнопку');
    $buttons = [[$button1],[$button2]];
    $inlineKeyboard = array("inline_keyboard" => $buttons);
    $inlineKeyboard = json_encode($inlineKeyboard,true);
    $parameters = [
        'chat_id' => $chat_id, 
        'text' => $reply, 
        'reply_markup' => $inlineKeyboard,
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters));
}
if(isset($output['callback_query']['data'])){
    $inline_chat_id = $output['callback_query']['message']['chat']['id'];
    $massage_id = $output['callback_query']['id'];
    $message = $output['callback_query']['message']['text'];
    sendMessage($token,$inline_chat_id,$massage);
}
function editMessage($token,$chat_id,$massage_id,$massage){
    $inline_chat_id = $output['callback_query']['message']['chat']['id'];
    $parameters = [
        'chat_id' => $inline_chat_id, 
        'message_id' => $massage_id,
        'text' => $massage_id, 
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters));
}


