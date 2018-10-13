<?php


function userfunc($user_id){
    $servername="db4free.net: 3306";
    $username="promocoder";
    $password="zdraste1234";
    $dbname="promocoder";
    $dbconnect = new mysqli($servername, $username, $password, $dbname); 
    
    $bool = FALSE;
    
    $sql = "SELECT user_id FROM users";
    $result = $dbconnect->query($sql);
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            if($row['user_id']==$login){
                sendMessage($token,$chat_id,$row['user_id']); 
                $bool=TRUE;                
                break;
            }
            else{
                sendMessage($token,$chat_id,$row['user_id']); 
                $bool = FALSE;
            }
        }    
    }
    
        
                  
    if($bool===FALSE){
        $createUser = "INSERT INTO users(user_id) VALUES('$user_id')";
        sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ'); 
    }
    else{  
        sendMessage($token,$chat_id,'ТЫ старый ПОЛЬЗОВАТЕЛЬ'); 
    }
      
    $dbconnect->close(); 
}

?>
