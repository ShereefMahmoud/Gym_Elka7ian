<?php

############################################################
///////// Connect with db
require '../../partials/db.php';
require '../../partials/functions.php';

$id = $_GET['id'];

$sql  = "select * From subscribe where id = $id";
$show = doQuery($sql);


if(mysqli_num_rows($show) == 0){
    $message = ["Fail" => "Invalid Data"];
    $_SESSION['Message'] = $message ;
    header("Location: index.php"); 
}else{
    $data = mysqli_fetch_assoc($show);
}

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

        $sql = "update subscribe set type = '$title' where id = $id ";
        $edit = doQuery($sql);
        if($edit){
            $message = ["Success" => "Raw Updated"];
            $_SESSION['Message'] = $message;
            header('Location: index.php');
            exit;
        }else{
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
            Messages('Dashboard / Subscribe / Edit');
            ?>


        </ol>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?id=". $data['id']; ?>" method="POST" >

            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" placeholder="Enter Title" value="<?php echo $data['type']; ?>">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>









<?php
require '../layouts/footer.php';
?>