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
    $key = sendKeyboard();
    sendMessage($token,$reply,$chat_id, $key);
}
function sendMessage($token,$reply,$chat_id, $key){
    $parameters = [
        'chat_id' => $chat_id,
        'text' => $reply,
    ];
    $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters) . '&reply_markup' . $key;
    file_get_contents($url);
}
function sendKeyboard(){
    $keyboard = [["Последние статьи"],["Картинка"],["Гифка"]]; //Клавиатура
    $reply_markup = json_encode([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
    return $reply_markup;
}
file_put_contents('logs.txt', $text);
