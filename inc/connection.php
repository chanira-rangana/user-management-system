<?php

    $host = 'localhost';
    $username = 'root';
    $password = '1234';
    $dbname = 'userdb';

    $connection = mysqli_connect($host,$username,$password,$dbname);

    //cheaking the connection
    if(mysqli_connect_errno()){
        die('Database connection failed '.mysqli_connect_error());
    } 
?>