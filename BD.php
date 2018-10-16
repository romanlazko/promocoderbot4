<?php


function userfunc($token,$chat_id,$user_id,$dbconnect){
    $result = $dbconnect->query("SELECT user_id FROM users");
    while($row = $result->fetch_assoc()){
        
        if($row['user_id']==$user_id){
            $new_user = false;
            break;
        }
        else{
            $new_user = true;            
        }
    }   
    if($new_user = false){
        sendMessage($token,$chat_id,'ТЫ СТАРЫЙ ПОЛЬЗОВАТЕЛЬ');
    }
    else{
        $createUser = "INSERT INTO users(user_id,userLat,userLong,position,posName) VALUES('$user_id','0','0','0','a')";            
        if($dbconnect->query($createUser) === TRUE){
            sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ'); 
        }
    }
   
};
function update($token,$chat_id,$dbconnect,$user_id,$latitude,$longitude){
    $putLocation = "UPDATE `users` SET `userLat` = '$latitude', `userLong` = '$longitude' WHERE `user_id` = '$user_id'";
    if($dbconnect->query($putLocation) === TRUE){
        sendMessage($token,$chat_id,'локация записанна'); 
    }
}
function takePos($token,$chat_id,$dbconnect,$user_id){
    $result = $dbconnect->query("SELECT position FROM users WHERE user_id = '$user_id'");
    while($row = $result->fetch_assoc()){
        
            sendMessage($token,$chat_id,$row['position']);
           
        
    }         
}
function takePosName($token,$user_id,$chat_id,$dbconnect,$inline_data){
    $takePosName = "UPDATE `users` SET `posName` = '$inline_data' WHERE `user_id` = '$user_id'";
    if($dbconnect->query($takePosName) === TRUE){
        sendMessage($token,$chat_id,$user_id); 
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
