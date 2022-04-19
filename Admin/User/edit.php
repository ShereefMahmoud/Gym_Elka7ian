<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

########################################################################################################
# Fetch Roles ..... 
$sql = "select * from user_type";
$type_op = doQuery($sql);
########################################################################################################



$id = $_GET['id'];

$sql  = "select *  From user  where id = $id";
$show = doQuery($sql);
if (mysqli_num_rows($show) == 0) {
    $message = ["Fail" => "Invalid Data"];
    $_SESSION['Message'] = $message;
    header("Location: index.php");
} else {
    $data = mysqli_fetch_assoc($show);
}

###########################################################################################
//////////////Form

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Fetch Data
    $name = cleanData($_POST['name']);
    $email = cleanData($_POST['email']);
    $password = cleanData($_POST['password']);
    $user_type_id = cleanData($_POST['user_type_id']);

    $errors = [];

    ////////Validate name
    if (!validate($name, 'reqiured')) {
        # code...
        $errors['Name'] = 'Field Required';
    } elseif (!validate($name, 'min', 3)) {
        $errors['Name'] = 'Field Length Must Be > = 3 char';
    }

    /////////Validate Email
    if (!validate($email, 'reqiured')) {
        # code...
        $errors['Email'] = 'Field Required';
    } elseif (!validate($email, 'email')) {
        $errors['Email'] = 'Invalid Format';
    }


    ////////////Validate User Type
    if (!validate($user_type_id, 'reqiured')) {
        # code...
        $errors['User Type'] = 'Field Required';
    } elseif (!validate($user_type_id, 'int')) {
        $errors['User Type'] = 'Field Must Be Int';
    }

    #Check Errors
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {


        ///////////db
        $sql   = "update user set name = '$name' , email = '$email' , user_type_id = $user_type_id where id = $id";
        $create = doQuery($sql);
        if ($create) {
            $message = ["Success" => "Raw Updated"];
            $_SESSION['Message'] = $message;
            header("Location: index.php");
        } else {
            $message = ["Fail" => " Update Row"];
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
            Messages('Dashboard / User / Edit');
            ?>


        </ol>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $data['id']; ?>" method="POST">

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name" value="<?php echo $data['name']; ?>" placeholder="Enter Name">
            </div>

            <div class="form-group">
                <label for="exampleInputName">email</label>
                <input type="email" class="form-control" required id="exampleInputName" aria-describedby="" name="email" value="<?php echo $data['email']; ?>" placeholder="Enter Email">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">User Type</label>
                <select class="form-control" name="user_type_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($type_op)) {
                    ?>
                        <option value="<?php echo $raw['id']; ?>" <?php if ($raw['id'] == $data['user_type_id']) {
                                                                        echo "selected";
                                                                    }  ?>><?php echo $raw['type']; ?></option>
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