<?php
// Defining the database connection parameters
$sname= "localhost:3307"; // this is the host name of phpadmin
$uname= "root"; // this is the user name of phpadmin
$password= ""; // this is the password of phpmyadmin but this user account has no password
$db_name= "ipt101"; // this is the name of the database

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn){ 
    echo 'Connection Failed';
}

