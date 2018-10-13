<?php


function userfunc($token,$chat_id,$user_id){
    
    $servername="db4free.net: 3306";
    $username="promocoder";
    $password="zdraste1234";
    $dbname="promocoder";
    $dbconnect = new mysqli($servername, $username, $password, $dbname); 
    
    /*$createUser = "INSERT INTO users(user_id) VALUES('$user_id')";
    if($dbconnect->query($createUser) === TRUE){
        
    }*/
    $result = $dbconnect->query("SELECT user_id FROM users");
    sendMessage($token,$chat_id,$result);
        /*while($row = $result->fetch_assoc()){
            if($row['user_id']==$user_id){
                sendMessage($token,$chat_id,$result); 
                $bool=TRUE;                
                break;
            }
            else{
                sendMessage($token,$chat_id,$result); 
                $bool = FALSE;
            }
        }   */
    $dbconnect->close(); 
}

?>
