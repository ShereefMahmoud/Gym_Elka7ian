<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

///////// Check Privilage If Admin
require '../partials/checkManager.php';

$id = $_GET['id'];

$sql  = "select * From user_type where id = $id";
$show_type = doQuery($sql);


if (mysqli_num_rows($show_type) == 0) {
    $message = ["Fail" => "Invalid Data"];
    $_SESSION['Message'] = $message;
    header("Location: index.php");
} else {
    $data_type = mysqli_fetch_assoc($show_type);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Fetch Data
    $type = cleanData($_POST['type']);

    $errors = [];

    if (!validate($type, 'reqiured')) {
        # code...
        $errors['Type'] = 'Field Required';
    } elseif (!validate($type, 'min', 3)) {
        $errors['Type'] = 'Field Length Must Be > = 3 char';
    }

    #Check Errors
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        $sql = "update user_type set type = '$type' where id = $id ";
        $edit_type = doQuery($sql);
        if ($edit_type) {
            $message = ["Success" => "Raw Updated"];
            $_SESSION['Message'] = $message;
            header('Location: index.php');
            exit;
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
            Messages('Dashboard / Type / Edit');
            ?>


        </ol>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $data_type['id']; ?>" method="POST">

            <div class="form-group">
                <label for="exampleInputName">Type</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="type" placeholder="Enter Title" value="<?php echo $data_type['type']; ?>">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>









<?php
require '../layouts/footer.php';
?>