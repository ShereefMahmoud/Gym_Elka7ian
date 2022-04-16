<?php
########### Connection With Db ###########
$server     = "localhost";
$dbName     = "gym";
$dbUser     = "root";
$dbPassword = "";

$connection = mysqli_connect($server , $dbUser , $dbPassword , $dbName);

if (!$connection) {
    # code...
    echo "Error : ".mysqli_connect_error();
}

?>