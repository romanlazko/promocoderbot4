<?php
/**
 * Created by PhpStorm.
 * User: Irina
 * Date: 04-Oct-18
 * Time: 15:51
 */
$token = "633839981:AAFtfuE_KVcHt1huA9RV6txQczt9It3xzI0";
$output = json_decode(file_get_contents('php://input'),true);

$keyboard = [["Последние статьи"],["Картинка"],["Гифка"]];

$text = $output['message']['text'];
$chat_id = $output['message']['chat']['id'];

if ($text == "/start") {
  $reply = "Добро пожаловать в бота!";
  $reply_markup = [
    'keyboard' => $keyboard, 
    'resize_keyboard' => true, 
    'one_time_keyboard' => false
  ]
  $parameters = [
        
        'chat_id' => $chat_id,
        'text' => $reply,
        'reply_markup' => $reply_markup,
    
  ];
}

$url = 'https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters);
file_get_contents($url);
file_put_contents('logs.txt', $text);

