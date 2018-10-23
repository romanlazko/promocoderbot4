<?php


function userfunc($token,$chat_id,$user_id,$dbconnect){
    $new_user = true;
    $result = $dbconnect->query("SELECT user_id FROM users");
    while($row = $result->fetch_assoc()){
        
        if($row['user_id']==$user_id){
            $new_user = false;
            break;
        }
    }   
    if($new_user === false){
        sendMessage($token,$chat_id,'ТЫ СТАРЫЙ ПОЛЬЗОВАТЕЛЬ');
    }
    else{
        $createUser = "INSERT INTO users(user_id,userLat,userLong,position,posName,pos_id) VALUES('$user_id','0','0','0','a','0')";            
        if($dbconnect->query($createUser) === TRUE){
            sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ'); 
        }
    }
   
};
function updateLocation($token,$chat_id,$dbconnect,$user_id,$latitude,$longitude){
    $putLocation = "UPDATE `users` SET `userLat` = '$latitude', `userLong` = '$longitude' WHERE `user_id` = '$user_id'";
    if($dbconnect->query($putLocation) === TRUE){
        if(distance('48.4420860','35.0160808',$latitude,$longitude) < 20000){
            $reply = 'Ваш город Днепр';        
        }
        else {
            $reply = 'Ваш город в Пизде мира';
        }
        $buttons = [["Настройки"],["Категории"]];
        sendKeyboard($token,$chat_id,$buttons,$reply);
    }
}
function showPos($position,$token,$dbconnect,$chat_id,$category){
    $result = $dbconnect->query("SELECT posName, pos_id FROM $category WHERE position = '$position'");
    while($row = $result->fetch_assoc()){
        inlineKeyboard($token,$chat_id,$row['posName'],More($row['pos_id'],$category,$row['pos_id']));        
    }   
}
function posData($pos_id,$dbconnect,$from){
    
    $result = $dbconnect->query("SELECT posName,more   FROM $from WHERE pos_id = '$pos_id'");
    while($row = $result->fetch_assoc()){        
        return array($row['more'],$row['posName']);
    }   
}


// function create($token,$chat_id,$dbconnect){
//     /*$login = "EatAndDrinks";
//     $ucertable = "CREATE TABLE $login (
//                     posName VARCHAR(30) NOT NULL,
//                     posLat VARCHAR(30) NOT NULL,
//                     posLong VARCHAR(30) NOT NULL,
//                     posShow VARCHAR(30) NOT NULL)";
//     if($dbconnect->query($ucertable) === TRUE){
//         sendMessage($token,$chat_id,'Создана таблица');
//     }  */    
//     $login = "MisterCat";
//     $createUser = "INSERT INTO EatAndDrinks(posName,posLat, posLong, posShow) VALUES('$login','48.4643541','35.0468668','notShow')";
//             if($dbconnect->query($createUser) === TRUE){
//                 sendMessage($token,$chat_id,'Добавлено'); 
//             }
// };

?>
