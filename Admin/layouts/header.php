<?php

#############################################################################
/////// Analysis For dashboard

$sql = "select count(id) as totalCoach from user where user_type_id = 2";
$count_coach = doQuery($sql);
$count_coach = mysqli_fetch_assoc($count_coach);
$count_coach=$count_coach['totalCoach'];


$sql = "select count(id) as totalMember from user where user_type_id = 7";
$count_member = doQuery($sql);
$count_member = mysqli_fetch_assoc($count_member);
$count_member=$count_member['totalMember'];

$sql = "select count(id) as totalRole from user_type";
$count_role = doQuery($sql);
$count_role = mysqli_fetch_assoc($count_role);
$count_role=$count_role['totalRole'];

$sql = "select count(id) as totalUser from user ";
$count_user = doQuery($sql);
$count_user = mysqli_fetch_assoc($count_user);
$count_user=$count_user['totalUser'];

##############################################################

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard </title>
        <link href="http://localhost/Gym_Elka7ian/Admin/resources/css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>