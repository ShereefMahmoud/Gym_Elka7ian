<?php

############################################################
///////// Connect with db
require '../../partials/db.php';
require '../../partials/functions.php';

if ($_SERVER['REQUEST_METHOD']=='POST') {
    # Fetch Data
    $title = cleanData($_POST['title']);

    $errors = [];

    if (!validate($title,'reqiured')) {
        # code...
        $errors['title']='Field Required';
    }elseif(!validate($title , 'min', 3)){
        $errors['title']='Field Length Must Be > = 3 char';
    }

    #Check Errors
    if(count($errors) > 0){
        $_SESSION['Message'] = $errors ;
    }else{
        $sql   ="insert into user_type (type) values ('$title')";
        $create = doQuery($sql);
        if($create){
            $message = ["Success" => "Raw Inserted"];
            $_SESSION['Message'] = $message;
            header("Location: index.php");
            
        }else{
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
            Messages('Dashboard / Roles / Create');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" >

            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" placeholder="Enter Title">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>









<?php
require '../layouts/footer.php';
?>