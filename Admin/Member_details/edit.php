<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

/////////////Check Privilage Admin Or Receptionist
require '../partials/checkManagerOrReception.php'; 

#####################################################################################################

///////////////// Get Data From Coach Table 
$sql = "select * from user where user_type_id = 2" ;
$coach_op = doQuery($sql);

####################################################################

///// Fetch User Data
$sql = "select user.* from user inner join user_type on user.user_type_id=user_type.id where type = 'member'";
$show_user = doQuery($sql);
#############################################################
///////////////// Get Data From Subscribe Table 
$sql = "select * from subscribe" ;
$sub_op = doQuery($sql);


########################################################################################################
# Fetch Feedback ..... 

$id = $_GET['id'];

$sql  = "select *  From member  where id = $id";
$show = doQuery($sql);
if (mysqli_num_rows($show) == 0) {
    $message = ["Fail" => "Invalid Data"];
    $_SESSION['Message'] = $message;
    header("Location: index.php");
} else {
    $show_member = mysqli_fetch_assoc($show);
}

###########################################################################################
//////////////Form

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Fetch Data
    $user_id   = cleanData($_POST['user_id']);
    $address   = cleanData($_POST['address']);
    $gender    = cleanData($_POST['gender']);
    $sub_id    = cleanData($_POST['sub_id']);
    $coach_id  = cleanData($_POST['coach_id']);
    $start_sub = cleanData($_POST['start_sub']);

    $date=date_create($start_sub);
    // date_modify($date,"+15 days");
    // $end_sub = date_format($date,"Y-m-d");
    // date_modify($date,"+15 days");
    // $end_sub = date_format($date,"Y-m-d");
    //  $end_sub = strtotime($end_sub);
    //  $start_sub=strtotime($start_sub);
    //  echo $start_sub . "<br>";
    //  echo $end_sub ;


    $errors = [];


    ////////////Validate User ID
    if (!validate($user_id, 'reqiured')) {
        # code...
        $errors['User ID '] = 'Field Required';
    } elseif (!validate($user_id, 'int')) {
        $errors['User ID '] = 'Field Must Be Int';
    }

    ////////Validate Address
    if (!validate($address, 'reqiured')) {
        # code...
        $errors['Address'] = 'Field Required';
    } elseif (!validate($address, 'min', 8)) {
        $errors['Adress'] = 'Field Length Must Be > = 8 char';
    }

    /////////Validate Gender
    if (!validate($gender, 'reqiured')) {
        # code...
        $errors['gender'] = 'Field Required';
    }

    ////////////Validate Salary 
    if (!validate($coach_id, 'reqiured')) {
        # code...
        $errors['Coach'] = 'Field Required';
    } elseif (!validate($coach_id, 'int')) {
        $errors['Coach'] = 'Field Must Be Int';
    }

    ////////////Validate Subscribe 
    if (!validate($sub_id, 'reqiured')) {
        # code...
        $errors['Subscribe'] = 'Field Required';
    } elseif (!validate($sub_id, 'int')) {
        $errors['Subscribe'] = 'Field Must Be Int';
    }

    ////////////Validate Date
    if (!validate($start_sub, 'reqiured')) {
        # code...
        $errors['Date'] = 'Field Required';
    } elseif (!validate($start_sub, 'date')) {
        $errors['Date'] = 'Must Be Present Or Future';
    }


    #Check Errors
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        if ($sub_id == 1) {
            # code...
            date_modify($date,"+1 monthss");
            $end_sub = date_format($date,"Y-m-d");
            $end_sub = strtotime($end_sub);
        }elseif($sub_id == 2){
            date_modify($date,"+6 monthss");
            $end_sub = date_format($date,"Y-m-d");
            $end_sub = strtotime($end_sub);
        }else{
            date_modify($date,"+1 years");
            $end_sub = date_format($date,"Y-m-d");
            $end_sub = strtotime($end_sub);
        }        

        $start_sub = strtotime($start_sub);

        ///////////db
        $sql   = "update member set address ='$address' , gender = '$gender' , subscribe_id = $sub_id , user_id = $user_id , start_subscribe = $start_sub , end_subscribe = $end_sub , coach_id = $coach_id where id = $id";
        $Update_member_datails = doQuery($sql);
        if ($Update_member_datails) {
            $message = ["Success" => "Raw Inserted"];
            $_SESSION['Message'] = $message;
            header("Location: index.php");
            exit;
        } else {
            $message = ["Fail" => " Insert Row"];
        }

        $_SESSION['Message'] = $message;
    }
}


############################################################
//////// call header and navbar
require '../layouts/header.php';
require '../layouts/navbar.php';
require '../layouts/sidebar.php';
?>


<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">


            <?php
            # Print Messages .... 
            Messages('Dashboard / Member / Edit');
            ?>


        </ol>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $show_member['id']; ?>" method="POST">

            <div class="form-group">
                <label for="exampleInputPassword">Name </label>
                <select class="form-control" name="user_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($show_user)) {
                    ?>
                        <option value="<?php echo $raw['id']; ?>" <?php if($raw['id']==$show_member['user_id']){echo "selected";} ?>><?php echo $raw['name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputName">address</label>
                <input type="address" class="form-control" required id="exampleInputName" aria-describedby="" value="<?php echo $show_member['address']; ?>" name="address" placeholder="Enter Address">
            </div>

            <div class="form-group" class="form-control">
                <label for="exampleInputName">Gender</label>
                <select class="form-control" name="gender">
                    <option value="male" <?php if ($show_member['gender'] == 'male') {
                                                echo "selected";
                                            } ?>>Male</option>
                    <option value="female" <?php if ($show_member['gender'] == 'female') {
                                                echo "selected";
                                            } ?>>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputName">Start Subscribe</label>
                <input type="date" class="form-control" required id="exampleInputName" aria-describedby="" value="" name="start_sub" placeholder="Enter Address">
            </div>

            <div class="form-group" class="form-control">
                <label for="exampleInputName">Coach</label>
                <select class="form-control" name="coach_id">
                <?php while($raw = mysqli_fetch_assoc($coach_op)){ ?> 
                            <option value="<?php echo $raw['id']; ?>" <?php if($raw['id'] == $show_member['coach_id']){echo "selected";}?>><?php echo $raw['name']; ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group" class="form-control">
                <label for="exampleInputName">Subscribe</label>
                <select class="form-control" name="sub_id">
                <?php while($raw = mysqli_fetch_assoc($sub_op)){ ?> 
                            <option value="<?php echo $raw['id'];  ?>" <?php if($raw['id']==$show_member['subscribe_id']){echo "selected";} ?>><?php echo $raw['type']; ?></option>
                <?php } ?>
                </select>
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>









<?php
require '../layouts/footer.php';
?>