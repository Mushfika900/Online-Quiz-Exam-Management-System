<?php
$serverName="localhost";
$username="root";
$password="";
$database="online_exam_db";

$conn=mysqli_connect($serverName,$username,$password,$database);

if(!$conn){
    die("Connection failed:".mysqli_connect_error());
}
else{
   
}

?>