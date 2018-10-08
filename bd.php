$login = "roman";

$servername="db4free.net: 3306";
    $username="promocoder";
    $password="zdraste1234";
    $dbname="promocoder";
    $dbconnect = new mysqli($servername, $username, $password, $dbname); 
 
    
            
            $ucertable = "CREATE TABLE $login (
                login VARCHAR(30) NOT NULL,
                test1result VARCHAR(30) NOT NULL,
                test2result VARCHAR(30) NOT NULL)";
            
            if($dbconnect->query($ucertable) === TRUE ){
                
                echo "Регистрация прошла успешно"."<br>";
                
            }
