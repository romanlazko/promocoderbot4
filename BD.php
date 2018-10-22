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
function takeUserPosName($dbconnect,$user_id){
    $result = $dbconnect->query("SELECT position,posName,pos_id FROM users WHERE user_id = '$user_id'");
    while($row = $result->fetch_assoc()){        
            return $row;      
    }   
}


function updateName($user_id,$dbconnect,$inline_data,$position){
    $updateName = "UPDATE `users` SET `position` = '$position', `posName` = '$inline_data' WHERE `users`.`user_id` = $user_id";
    if($dbconnect->query($updateName) === TRUE){
        return TRUE;
    }
}
function showPos($posShow,$token,$dbconnect,$chat_id){
    
    $result = $dbconnect->query("SELECT posName, pos_id FROM EatAndDrinks WHERE posShow = '$posShow'");
    while($row = $result->fetch_assoc()){
        inlineKeyboard($token,$chat_id,$row['posName'],More($row['pos_id']));        
    }   
}
function showMore($inline_data,$dbconnect){
    
    $result = $dbconnect->query("SELECT more FROM EatAndDrinks WHERE pos_id = '$inline_data'");
    while($row = $result->fetch_assoc()){        
        return $row['more'];
    }   
}
function takePosName($dbconnect,$user_id,$pos_id){
     
    $result = $dbconnect->query("SELECT posName FROM EatAndDrinks WHERE pos_id = '$pos_id'");
    while($row = $result->fetch_assoc()){        
        return $row['posName'];      
    }   
}
function setMore($inline_data,$dbconnect){
    
    $result = $dbconnect->query("SELECT pos_id FROM EatAndDrinks");
    while($row = $result->fetch_assoc()){        
        if($row['pos_id'] == $inline_data){
            return $row['pos_id'];
        }      
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
