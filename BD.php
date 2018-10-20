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
        $createUser = "INSERT INTO users(user_id,userLat,userLong,position,posName,'pos_id') VALUES('$user_id','0','0','0','a','0')";            
        if($dbconnect->query($createUser) === TRUE){
            sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ'); 
        }
    }
   
};
function updateLocation($token,$chat_id,$dbconnect,$user_id,$latitude,$longitude){
    $putLocation = "UPDATE `users` SET `userLat` = '$latitude', `userLong` = '$longitude' WHERE `user_id` = '$user_id'";
    if($dbconnect->query($putLocation) === TRUE){
        sendMessage($token,$chat_id,'локация записанна'); 
    }
}
function takeUserPos($dbconnect,$user_id){
    $result = $dbconnect->query("SELECT position FROM users WHERE user_id = '$user_id'");
    while($row = $result->fetch_assoc()){        
            return $row['position'];      
    }   
}
function takeUserName($dbconnect,$user_id){
    $result = $dbconnect->query("SELECT posName FROM users WHERE user_id = '$user_id'");
    while($row = $result->fetch_assoc()){        
            return $row['posName'];      
    }   
}
function takePosId($dbconnect,$posName){
    $result = $dbconnect->query("SELECT pos_id FROM EatAndDrinks WHERE posName = '$posName'");
    while($row = $result->fetch_assoc()){        
            return $row['pos_id'];      
    }   
}
function updateName($token,$user_id,$chat_id,$dbconnect,$inline_data,$position){
    $updateName = "UPDATE `users` SET `position` = '$position', `posName` = '$inline_data' WHERE `users`.`user_id` = $user_id";
    if($dbconnect->query($updateName) === TRUE){
        showPos(takeUserPos($dbconnect,$user_id),$token,$dbconnect,$chat_id); 
    }
}
function showPos($posShow,$token,$dbconnect,$chat_id){
    
    $result = $dbconnect->query("SELECT posName, pos_id FROM EatAndDrinks WHERE posShow = '$posShow'");
    while($row = $result->fetch_assoc()){
        inlineKeyboard($token,$chat_id,$row['posName'],More($row['pos_id']));
        sendMessage($token,$chat_id,$row['pos_id']);
        
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
