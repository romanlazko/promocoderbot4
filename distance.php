<?php
$latitude = $output['message']['location']['latitude'];
$longitude = $output['message']['location']['longitude'];
define('EARTH_RADIUS', 6372795);

function distance($φA, $λA, $φB, $λB) {
    $lat1 = $φA * M_PI / 180;
    $lat2 = $φB * M_PI / 180;
    $long1 = $λA * M_PI / 180;
    $long2 = $λB * M_PI / 180;
    
    $cl1 = cos($lat1);
    $cl2 = cos($lat2);
    $sl1 = sin($lat1);
    $sl2 = sin($lat2);
    $delta = $long2 - $long1;
    $cdelta = cos($delta);
    $sdelta = sin($delta);
 
    $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
    $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;
 
    $ad = atan2($y, $x);
    $dist = $ad * EARTH_RADIUS;
 
    return $dist;
}

$dist = distance('48.4420860','35.0160808',$latitude,$longitude);

if(isset($latitude) or isset($longitude)){
    if($dist < 20000){
        $reply = 'Ваш город Днепр';
        $buttons = [["Настройки"],["Категории"]];
        sendKeyboard($token,$chat_id,$buttons,$reply);
    }
    
}
?>
