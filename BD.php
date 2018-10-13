<?php


function userfunc($user_id){
    $servername="db4free.net: 3306";
    $username="promocoder";
    $password="zdraste1234";
    $dbname="promocoder";
    $dbconnect = new mysqli($servername, $username, $password, $dbname); 

    $bd_user_id = "SELECT user_id FROM users";
    $result = $dbconnect->query($bd_user_id);
    
    while($row = $result->fetch_assoc()){
        if($row['user_id']==$user_id){
            sendMessage($token,$chat_id,'ТЫ УЖЕ ОПЫТНЫЙ ПОЛЬЗОВАТЕЛЬ');
            break;
        }
        else{
            $createUser = "INSERT INTO users(user_id) VALUES('$user_id')";
            if($dbconnect->query($createUser) === TRUE ){
                 sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ');
            }               
        }
    }   
    $dbconnect->close(); 
}

?>
