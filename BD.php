<?php
$servername="db4free.net: 3306";
$username="promocoder";
$password="zdraste1234";
$dbname="promocoder";


function userfunc($token,$chat_id,$user_id){
   $dbconnect = new mysqli($servername, $username, $password, $dbname); 
    $sql = "SELECT user_id FROM users";
    $result = $dbconnect->query($sql);
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
   $dbconnect->close();
}

?>
