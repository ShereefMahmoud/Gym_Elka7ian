<?php

############################################################
///////// Connect with db
require '../partials/db.php';
require '../partials/functions.php';

#############################################################

///////// Check Privilage If Admin
require '../partials/checkMember.php';
########################################################################

///////////// Form

$user_id = $_SESSION['user']['id'];

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
        $sql   = "insert into feedback ( title , content , user_id) values ('$title','$content', $user_id)";
        $create_feedback = doQuery($sql);
        if ($create_feedback) {
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
?>


<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">


            <?php
            # Print Messages .... 
            Messages('Member / Feedback / Send');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" placeholder="Enter Name">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Content</label>
                <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>









<?php
require '../layouts/footer.php';
?>