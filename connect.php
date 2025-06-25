<?php

$host="localhost";
$user="root";
$pass="Bnfrrbnd!1234";
$db="login";
$port = 3306; 

$conn=new mysqli($host,$user,$pass,$db,$port);
if($conn->connect_error){
    echo "Failed to connect DB".$conn->connect_error;
}
?>

