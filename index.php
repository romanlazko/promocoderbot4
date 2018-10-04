<?php
/**
 * Created by PhpStorm.
 * User: Irina
 * Date: 04-Oct-18
 * Time: 15:51
 */
$token = "633839981:AAFtfuE_KVcHt1huA9RV6txQczt9It3xzI0";
$output = json_decode(file_get_contents('php://input'),true);

$text = $output['message']['text'];
$chat_id = $output['message']['chat']['id'];

if ($text == "/start") {
    $reply = "Добро пожаловать в бота!";
    sendKeyboard($token,$chat_id);
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
function sendKeyboard($token,$chat_id){
    $buttons = [["Последние статьи"],["Картинка"],["Гифка"]]; //Клавиатура
    $reply_markup =  ([ 'keyboard' => $buttons, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);    
    $parameters = [
        'chat_id' => $chat_id,
    ];
    $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters) . '&reply_markup=' . $reply_markup;
    file_get_contents($url);
}
