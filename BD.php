<?php


function userfunc($user_id){
    $servername="db4free.net: 3306";
    $username="promocoder";
    $password="zdraste1234";
    $dbname="promocoder";
    $dbconnect = new mysqli($servername, $username, $password, $dbname); 
    sendMessage($token,$chat_id,$user_id); 
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
    
    
        
                  
    if($bool===FALSE){
        
        sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ'); 
    }
    else{  
        sendMessage($token,$chat_id,'ТЫ старый ПОЛЬЗОВАТЕЛЬ'); 
    }
      
    $dbconnect->close(); 
}

?>
