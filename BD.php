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
function create($token,$chat_id,$dbconnect){
    $login = "eAd";
    $ucertable = "CREATE TABLE $login (
                    name VARCHAR(30) NOT NULL,
                    location VARCHAR(30) NOT NULL,
                    show VARCHAR(30) NOT NULL)";
    if($dbconnect->query($ucertable) === TRUE){
        sendMessage($token,$chat_id,'Создана таблица');
    }       
};

?>
