<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';
#####################################################################################################

/////////////Check Privilage Admin Or Receptionist
require '../partials/CheckManagerOrReception.php'; 

#############################################################

#Fetch User data
$sql = "select user.* from user inner join user_type on user.user_type_id=user_type.id where type = 'coach'";
$show_user = doQuery($sql);

########################################################################################################
# Fetch Feedback ..... 

$id = $_GET['id'];

$sql  = "select *  From coach  where id = $id";
$show = doQuery($sql);
if (mysqli_num_rows($show) == 0) {
    $message = ["Fail" => "Invalid Data"];
    $_SESSION['Message'] = $message;
    header("Location: index.php");
} else {
    $show_coach = mysqli_fetch_assoc($show);
}

###########################################################################################
//////////////Form

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Fetch Data
    $user_id = cleanData($_POST['user_id']);
    $address = cleanData($_POST['address']);
    $gender = cleanData($_POST['gender']);
    $salary = cleanData($_POST['salary']);

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
    if (!validate($salary, 'reqiured')) {
        # code...
        $errors['Salary'] = 'Field Required';
    } elseif (!validate($salary, 'int')) {
        $errors['Salary'] = 'Field Must Be Int';
    }


    #Check Errors
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        $sql = "select * from coach where user_id = $user_id";
        $check = doQuery($sql);
        if(mysqli_num_rows($check) > 1){
            $message = ["Coach Details" => " Alredy Exit"];
        }else{
        ///////////db
        $sql   = "update coach set address = '$address' , gender = '$gender' , salary = $salary , user_id = $user_id where id = $id";
        $update_coach_datails = doQuery($sql);
        if ($update_coach_datails) {
            $message = ["Success" => "Raw Updated"];
            $_SESSION['Message'] = $message;
            header("Location: index.php");
            exit;
        } else {
            $message = ["Fail" => " update Row"];
        }
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
            Messages('Dashboard / Coach / Edit');
            ?>


        </ol>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $show_coach['id']; ?>" method="POST">

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
                <input type="address" class="form-control" required id="exampleInputName" aria-describedby="" value="<?php echo $show_coach['address']; ?>" name="address" placeholder="Enter Address">
            </div>

            <div class="form-group" class="form-control">
                <label for="exampleInputName">Gender</label>
                <select class="form-control" name="gender">
                    <option value="male" <?php if ($show_coach['gender'] == 'male') {
                                                echo "selected";
                                            } ?>>Male</option>
                    <option value="female" <?php if ($show_coach['gender'] == 'female') {
                                                echo "selected";
                                            } ?>>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputName">Salary</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" value="<?php echo $show_coach['salary']; ?>" name="salary" placeholder="Enter Salary">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>









<?php
require '../layouts/footer.php';
?>