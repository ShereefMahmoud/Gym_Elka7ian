<?php

session_start();


########### Connection With Db ###########
$server     = "localhost";
$dbName     = "gym";
$dbUser     = "root";
$dbPassword = "";

$connection = mysqli_connect($server , $dbUser , $dbPassword , $dbName);

if (!$connection) {
    # code...
    die ("Error : ".mysqli_connect_error());
}

function doQuery($sql){
    return mysqli_query($GLOBALS['connection'],$sql);
}

?>