<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

///////// Check Privilage If Admin
require '../partials/checkManager.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Fetch Data
    $type = cleanData($_POST['type']);

    $errors = [];

    if (!validate($ype, 'reqiured')) {
        # code...
        $errors['User Type'] = 'Field Required';
    } elseif (!validate($type, 'min', 3)) {
        $errors['User Type'] = 'Field Length Must Be > = 3 char';
    }

    #Check Errors
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {
        $sql   = "insert into user_type (type) values ('$type')";
        $create_type = doQuery($sql);
        if ($create_type) {
            $message = ["Success" => "Raw Inserted"];
        } else {
            $message = ["Fail" => " Insert Row"];
        }

        $_SESSION['Message'] = $message;
        header('Location: index.php');
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
            Messages('Dashboard / Role / Create');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <div class="form-group">
                <label for="exampleInputName">User Type</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="type" placeholder="Enter type">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>









<?php
require '../layouts/footer.php';
?>