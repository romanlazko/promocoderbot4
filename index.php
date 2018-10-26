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
$message_id = $output['callback_query']['message']['message_id'];
$latitude = $output['message']['location']['latitude'];
$longitude = $output['message']['location']['longitude'];
$first_name = $output['message']['from']['first_name'];



include 'BD.php';


if(isset($inline_data)){
    $chat_id = $output['callback_query']['message']['chat']['id'];
    $user_id = $output['callback_query']['from']['id'];
    
    $str = substr($inline_data, 0, strrpos($inline_data, '/'));
    $category = substr($str, strrpos($str,"/")+1);
    $button = substr($str, 0, strrpos($str, '/'));
    $pos_id = substr($inline_data, strrpos($inline_data,"/")+1);
    
}else{
    $button = $output['message']['text'];
    $chat_id = $output['message']['chat']['id'];
    $user_id = $output['message']['from']['id'];
}
    
switch ($button) {
    case 'category':        
        showPos(1,$token,$dbconnect,$chat_id,$category);
        inlineKeyboard($token,$chat_id,'Показать еще',nextprev($category,1));
        break;
    case 'more':        
        editMassage($token,$chat_id,$message_id,posData($pos_id,$dbconnect,$category)['more'],Code($category,$pos_id));
        break;
    case 'promocode':    
        include 'promocode.php';
        $promocode = promocodeExam($token,$chat_id,$dbconnect,$pos_id,$user_id,promocode());
        $reply = posData($pos_id,$dbconnect,$category)['posName']."\n"."\n"."*Промо-код:* ".$promocode;
        //promocodeExam($token,$chat_id,$dbconnect,$pos_id,$user_id,$promocode);
        editMassage($token,$chat_id,$message_id,$reply,More($pos_id,$category));
        break;
    case 'nextfun':        
        $position = $pos_id + 1;
        showPos($position,$token,$dbconnect,$chat_id,$category);
        deleteMessage($token,$chat_id,$message_id);
        inlineKeyboard($token,$chat_id,'Показать еще',nextprev($category,$position));
        break;   
    case '/start':
        
        $reply = "Привет ".$first_name.".\n".
            "Добро пожаловать в бота!
            \n*Список доступных команд:*
            \n/start\n/help
            \nЧтобы начать, отправь свою геолокацию!";
        userfunc($token,$chat_id,$user_id,$dbconnect);
        $buttons = [[['text'=>"ОТПРАВИТЬ ГЕОЛОКАЦИЮ",'request_location'=>true]],["Категории"]];
        sendKeyboard($token,$chat_id,$buttons,$reply);
        break;
    case 'Настройки':
        $reply = "Тут нихуя не работает, хули палишь?";
        sendMessage($token,$chat_id,$reply);
        break;
    case 'Категории':
        $reply = "Выберете категорию";
        inlineKeyboard($token,$chat_id,$reply,category());
        break;  
}

if(isset($latitude) or isset($longitude)){
    include 'distance.php';
    updateLocation($token,$chat_id,$dbconnect,$user_id,$latitude,$longitude);
    $reply = "Выберете категорию";
    inlineKeyboard($token,$chat_id,$reply,category());
}

          


function nextprev($category,$nextpos){
    $next = array('text' => '⬇️⬇️⬇️', 'callback_data' => 'nextfun/'.$category.'/'.$nextpos);
    $buttons = [
         [$next]
    ];
    return $buttons;
}
function More($more,$category){
    $more = array('text' => 'Подробнее', 'callback_data' => 'more/'.$category.'/'.$more);
    $buttons = [
         [$more]
    ];  
    return $buttons;
}
function Code($category,$code){    
    $promocode = array('text' => 'Получить промо-код', 'callback_data' => 'promocode/'.$category.'/'.$code);
    $buttons = [
         [$promocode]
    ];  
    return $buttons;
}

function category(){
    $eatAndFood = array('text' => 'Еда и напитки', 'callback_data' => 'category/'.'EatAndDrinks/'.'1');
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
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters).'&parse_mode=Markdown');
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
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters).'&parse_mode=Markdown');
}

function inlineKeyboard($token,$chat_id,$reply,$buttons){
    $inlineKeyboard = json_encode(array("inline_keyboard" => $buttons),true);
    $parameters = [
        'chat_id' => $chat_id, 
        'text' => $reply, 
        'reply_markup' => $inlineKeyboard,
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters).'&parse_mode=Markdown');
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
    file_get_contents('https://api.telegram.org/bot' . $token . '/editMessageText?' . http_build_query($parameters).'&parse_mode=Markdown');
}
function deleteMessage($token,$chat_id,$message_id){     
    $parameters = [
        'chat_id' => $chat_id, 
        'message_id' => $message_id, 
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/deleteMessage?' . http_build_query($parameters));
}
$dbconnect->close();
    //showMore($inline_data,$token,$dbconnect,$chat_id,$message_id,$user_id);
//     if($inline_data == 'promocode'){
        
//         $reply = takePosName($dbconnect,$user_id,$POS_NAME['pos_id'])."\n"."Промо-код: "."\n".promocode();
//         editMassage($token,$chat_id,$message_id,$reply,More($POS_NAME['pos_id']));
//     }
    //         inlineKeyboard($token,$chat_id,$reply,nextprev());
//deleteMessage($token,$chat_id,$message_id);
        //sendMessage($token,$inline_chat_id,'[​​​​​​​​​​​](https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/Stack_Overflow_logo.svg/200px-Stack_Overflow_logo.svg.png) Some text here.');
?>
