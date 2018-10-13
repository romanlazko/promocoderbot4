<?php


function userfunc($token,$chat_id,$user_id){
    sendMessage($token,$chat_id,'нихуя'); 
    /*$servername="db4free.net: 3306";
    $username="promocoder";
    $password="zdraste1234";
    $dbname="promocoder";
    $dbconnect = new mysqli($servername, $username, $password, $dbname); 
    $bool = FALSE;
    $createUser = "INSERT INTO users(user_id) VALUES('$user_id')";
    $createUser = "INSERT INTO users(user_id) VALUES('$chat_id')";
    $sql = "SELECT user_id FROM users";
    $result = $dbconnect->query($sql);
    
        while($row = $result->fetch_assoc()){
            if($row['user_id']==$user_id){
                sendMessage($token,$chat_id,$result); 
                $bool=TRUE;                
                break;
            }
            else{
                sendMessage($token,$chat_id,$result); 
                $bool = FALSE;
            }
        }   
    $dbconnect->close(); */
}

?>
