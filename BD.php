<?php

$servername="db4free.net: 3306";
$username="promocoder";
$password="zdraste1234";
$dbname="promocoder";
$dbconnect = new mysqli($servername, $username, $password, $dbname); 

function userfunc($user_id){
    $bd_user_id = "SELECT user_id FROM users";
    $result = $dbconnect ->query($bd_user_id);
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            if($row['user_id']==$user_id){
                sendMessage($token,$chat_id,'ТЫ УЖЕ ОПЫТНЫЙ ПОЛЬЗОВАТЕЛЬ');
                break;
            }
            else{
                $createUser = "INSERT INTO users(user_id) VALUES($user_id)";
                sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ');
                
            }
        }
        
    }
    else{
                $createUser = "INSERT INTO users(user_id) VALUES($user_id)";
        sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ');
                
            }
/*$ucertable = "CREATE TABLE $login (
    login VARCHAR(30) NOT NULL,
    test1result VARCHAR(30) NOT NULL,
    test2result VARCHAR(30) NOT NULL)";      
    if($dbconnect->query($ucertable) === TRUE ){
        echo "Регистрация прошла успешно"."<br>";
                
    }*/
}
?>
