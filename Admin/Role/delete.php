<?php

############################################################
///////// Connect with db
require '../../partials/db.php';
require '../../partials/functions.php';


$id = $_GET['id'];

#############################################################
//////////Validate Integer
if (!validate($id,'int')) {
    # code...
    $message = ["Error" => "Invalid Id"];
}else{
    $sql    =  "delete from user_type where id = $id";
    $delete = doQuery($sql);
    if ($delete) {
        # code...
        $message = ["Success" => "Raw Deleted"];
    }else{
        $message = ["Fail" => "Fail To  Delete Raw"];
    }
}

$_SESSION['Message'] = $message;
header("Location: index.php");



?>





