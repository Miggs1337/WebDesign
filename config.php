<?php
   define('DB_SERVER', 'localhost:3036');
   define('DB_USERNAME', 'admin');
   define('DB_PASSWORD', 'Angels!1337');
   define('DB_DATABASE', 'dbUsers');
   //Login attempt with given login credentials
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	
	//Check the connection
   if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>