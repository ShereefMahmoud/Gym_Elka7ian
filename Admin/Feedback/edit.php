<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

########################################################################################################
# Fetch Feedback ..... 

$id = $_GET['id'];

$sql  = "select *  From feedback  where id = $id";
$show = doQuery($sql);
if (mysqli_num_rows($show) == 0) {
    $message = ["Fail" => "Invalid Data"];
    $_SESSION['Message'] = $message;
    header("Location: index.php");
} else {
    $show_feedback = mysqli_fetch_assoc($show);
}

###########################################################################################
//////////////Form

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Fetch Data
    $title = cleanData($_POST['title']);
    $content = cleanData($_POST['content']);

    $errors = [];

    ////////Validate name
    if (!validate($title, 'reqiured')) {
        # code...
        $errors['Name'] = 'Field Required';
    } elseif (!validate($title, 'min')) {
        $errors['Title'] = 'Field Length Must Be > = 6 char';
    }

    /////////Validate Email
    if (!validate($content, 'reqiured')) {
        # code...
        $errors['Content'] = 'Field Required';
    } elseif (!validate($content, 'min', 50)) {
        $errors['Content'] = 'Invalid Format';
    }

    #Check Errors
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {


        ///////////db
        $sql   = "update feedback set title = '$title' , content = '$content' where id = $id";
        $update_feedback = doQuery($sql);
        if ($update_feedback) {
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
            Messages('Dashboard / Feedback / Edit');
            ?>


        </ol>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $show_feedback['id']; ?>" method="POST">

            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" value="<?php echo $show_feedback['title']; ?>" placeholder="Enter Name">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Content</label>
                <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"><?php echo $show_feedback['content']; ?></textarea>
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>









<?php
require '../layouts/footer.php';
?>