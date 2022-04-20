<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

/////////////Check Privilage Admin Or Receptionist
require '../partials/checkManagerOrReceptionOrCoach.php'; 

#############################################################

///// Fetch User Data
$sql = "select user.* from user inner join user_type on user.user_type_id=user_type.id where type = 'member'";
$show_user = doQuery($sql);
#############################################################

///////////////// Get Data From Subscribe Table 
$sql = "select * from subscribe" ;
$sub_op = doQuery($sql);

##############################################################3

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Fetch Data
    $user_id   = cleanData($_POST['user_id']);
    $address   = cleanData($_POST['address']);
    $gender    = cleanData($_POST['gender']);
    $start_sub = strtotime(cleanData($_POST['start_sub']));
    $sub_id    = cleanData($_POST['sub_id']);

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

    ////////Validate Date
    if (!validate($start_sub, 'reqiured')) {
        # code...
        $errors['Start Subscribe'] = 'Field Required';
     }
    // elseif (!validate($start_sub, 'date')) {
    //     $errors['Start Subscribe'] = 'Must Be Present Or Future';
    // }

    ////////////Validate Salary 
    if (!validate($sub_id, 'reqiured')) {
        # code...
        $errors['Subscribe'] = 'Field Required';
    } elseif (!validate($sub_id, 'int')) {
        $errors['Subscribe'] = 'Field Must Be Int';
    }


    #Check Errors
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {
        //$start_sub = date_format($start_sub,'Y-m-d');
        // echo $start_sub;
        // exit;

        //$d = new DateTime( '2010-01-08' );
        //modify( 'last day of next month' );
        
        //echo date_format($date,"Y-m-d");
        if ($sub_id == 1) {
            # code...
            $end_sub = strtotime('+1 months');
        }elseif($sub_id == 2){
            $end_sub = strtotime('+6 months');
        }else{
            $end_sub = strtotime('+1 years');
        }        

        ///////////db
        $sql   = "insert into member ( address , gender , subscribe_id , user_id , active , start_subscribe , end_subscribe) values ('$address','$gender',$sub_id,$user_id , 1 , $start_sub , '$end_sub')";
        $create_member_datails = doQuery($sql);
        if ($create_member_datails) {
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
            Messages('Dashboard / Member_Datails / Create');
           
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <div class="form-group">
                <label for="exampleInputPassword">Name </label>
                <select class="form-control" name="user_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($show_user)) {
                    ?>
                        <option value="<?php echo $raw['id']; ?>"><?php echo $raw['name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputName">address</label>
                <input type="address" class="form-control" required id="exampleInputName" aria-describedby="" name="address" placeholder="Enter Address">
            </div>

            <div class="form-group" class="form-control">
                <label for="exampleInputName">Gender</label>
                <select class="form-control" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputName">Start Subscribe</label>
                <input type="date" class="form-control" required id="exampleInputName" aria-describedby="" name="start_sub">
            </div>

            <div class="form-group" class="form-control">
                <label for="exampleInputName">Subscribe</label>
                <select class="form-control" name="sub_id">
                <?php while($raw = mysqli_fetch_assoc($sub_op)){ ?> 
                            <option value="<?php echo $raw['id']; ?>"><?php echo $raw['type']; ?></option>
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