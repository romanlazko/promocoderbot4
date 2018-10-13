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
   
}
function create($token,$chat_id){
    sendMessage($token,$chat_id,'создаем таблицу');
    $pos = 'eatAndDrinks';
    $ucertable = "CREATE TABLE $pos (
                Name VARCHAR(30) NOT NULL,
                Location VARCHAR(30) NOT NULL,
                show VARCHAR(30) NOT NULL)";
}

?>
