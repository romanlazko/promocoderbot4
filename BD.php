<?php


function userfunc($token,$chat_id,$user_id,$dbconnect){
    
    $result = $dbconnect->query("SELECT user_id FROM users");
    while($row = $result->fetch_assoc()){
        if($row['user_id']==$user_id){
            sendMessage($token,$chat_id,'ТЫ СТАРЫЙ ПОЛЬЗОВАТЕЛЬ');
            break;
        }
        else{
            $createUser = "INSERT INTO users(user_id) VALUES('$user_id')";
            
            if($dbconnect->query($createUser) === TRUE){
                sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ'); 
            }
        }
    }   
   
};
function update($token,$chat_id,$dbconnect,$user_id){
    $putLocation = "UPDATE `users` SET `lat` = '1', `long` = '2', `position` = '3' WHERE `users`.'user_id' = '544883527'";
    if($dbconnect->query($putLocation) === TRUE){
        sendMessage($token,$chat_id,'локация записанна'); 
    }
}
function create($token,$chat_id,$dbconnect){
    /*$login = "EatAndDrinks";
    $ucertable = "CREATE TABLE $login (
                    posName VARCHAR(30) NOT NULL,
                    posLat VARCHAR(30) NOT NULL,
                    posLong VARCHAR(30) NOT NULL,
                    posShow VARCHAR(30) NOT NULL)";
    if($dbconnect->query($ucertable) === TRUE){
        sendMessage($token,$chat_id,'Создана таблица');
    }  */    
    $login = "MisterCat";
    $createUser = "INSERT INTO EatAndDrinks(posName,posLat, posLong, posShow) VALUES('$login','48.4643541','35.0468668','notShow')";
            if($dbconnect->query($createUser) === TRUE){
                sendMessage($token,$chat_id,'Добавлено'); 
            }
};

?>
