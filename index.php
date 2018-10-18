<?php
$servername="db4free.net: 3306";
$username="promocoder";
$password="zdraste1234";
$dbname="promocoder";
$dbconnect = new mysqli($servername, $username, $password, $dbname);


define('EARTH_RADIUS', 6372795);
$token = "633839981:AAHmf8yb2TJ9oEIL9ia2qYnrbbaWb6ULaBQ";

$output = json_decode(file_get_contents('php://input'),true);

$inline_data = $output['callback_query']['data'];
$inline_chat_id = $output['callback_query']['message']['chat']['id'];
$inline_user_id = $output['callback_query']['from']['id'];
$message_id = $output['callback_query']['message']['message_id'];
$text = $output['message']['text'];
$chat_id = $output['message']['chat']['id'];
$user_id = $output['message']['from']['id'];
$latitude = $output['message']['location']['latitude'];
$longitude = $output['message']['location']['longitude'];



include 'distance.php';
include 'BD.php';


if(isset($latitude) or isset($longitude)){
    updateLocation($token,$chat_id,$dbconnect,$user_id,$latitude,$longitude);
    if(distance('48.4420860','35.0160808',$latitude,$longitude) < 20000){
        $reply = 'Ваш город Днепр';
        $buttons = [["Настройки"],["Категории"]];
        sendKeyboard($token,$chat_id,$buttons,$reply);
    }
}
if(isset($inline_data)){
    if($inline_data == 'EatAndDrinks'){
    $reply = 'Категория '.$inline_data;
        updateName($token,$inline_user_id,$inline_chat_id,$dbconnect,$inline_data,1);
        inlineKeyboard($token,$inline_chat_id,$reply,nextprev());
    }
    if($inline_data == 'nextfun'){
        $reply = 'Категория '.takeUserName($dbconnect,$inline_user_id);
        $position = takeUserPos($dbconnect,$inline_user_id) + 1;
        updateName($token,$inline_user_id,$inline_chat_id,$dbconnect,takeUserName($dbconnect,$inline_user_id),$position);
        deleteMessage($token,$inline_chat_id,$message_id);
        inlineKeyboard($token,$inline_chat_id,$reply,nextprev());
    }
    if($inline_data == 'prevfun'){
        $reply = 'Категория '.takeUserName($dbconnect,$inline_user_id);
        $position = takeUserPos($dbconnect,$inline_user_id) - 1;
        updateName($token,$inline_user_id,$inline_chat_id,$dbconnect,takeUserName($dbconnect,$inline_user_id),$position);
        inlineKeyboard($token,$inline_chat_id,$reply,nextprev());
    }
}
if ($text == "/start" ) {
    $reply = "Добро пожаловать в бота! Чтобы начать, отправь свою геолокацию!";
    userfunc($token,$chat_id,$user_id,$dbconnect);
    $buttons = [[['text'=>"ОТПРАВИТЬ ГЕОЛОКАЦИЮ",'request_location'=>true]]];
    sendKeyboard($token,$chat_id,$buttons,$reply);   
}

if ($text == "Категории") {
    $reply = "Выберете категорию";
    inlineKeyboard($token,$chat_id,$reply,category());
}
function nextprev(){
    $prev = array('text' => 'Предидущие', 'callback_data' => 'prevfun');
    $next = array('text' => 'Следующие', 'callback_data' => 'nextfun');
    $buttons = [
         [$prev],[$next]
    ];
    
    
    return $buttons;
}
function category(){
    $eatAndFood = array('text' => 'Еда и напитки', 'callback_data' => 'EatAndDrinks');
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
function deleteMessage($token,$chat_id,$message_id){     
    $parameters = [
        'chat_id' => $chat_id, 
        'message_id' => $message_id, 
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/deleteMessage?' . http_build_query($parameters));
}
$dbconnect->close();

