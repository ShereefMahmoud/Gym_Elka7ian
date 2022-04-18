<?php

############################################################
///////// Connect with db
require '../../partials/db.php';
require '../../partials/functions.php';

#############################################################

///// Fetch User_Type Data
$sql = "select * from user_type";
$show = doQuery($sql);
#############################################################

if ($_SERVER['REQUEST_METHOD']=='POST') {
    # Fetch Data
    $name = cleanData($_POST['name']);
    $email = cleanData($_POST['email']);
    $password = cleanData($_POST['password']);
    $user_type_id = cleanData($_POST['user_type_id']);

    $errors = [];

    ////////Validate name
    if (!validate($name,'reqiured')) {
        # code...
        $errors['Name']='Field Required';
    }elseif(!validate($name , 'min', 3)){
        $errors['Name']='Field Length Must Be > = 3 char';
    }

    /////////Validate Email
    if (!validate($email,'reqiured')) {
        # code...
        $errors['Email']='Field Required';
    }elseif(!validate($email , 'email')){
        $errors['Email']='Invalid Format';
    }

    ////////////Validate Password
    if (!validate($password,'reqiured')) {
        # code...
        $errors['Password']='Field Required';
    }elseif(!validate($password , 'min')){
        $errors['Password']='Field Length Must Be > = 6 char';
    }

    ////////////Validate User Type
    if (!validate($user_type_id,'reqiured')) {
        # code...
        $errors['User Type']='Field Required';
    }elseif(!validate($user_type_id , 'int')){
        $errors['User Type']='Field Must Be Int';
    }

    #Check Errors
    if(count($errors) > 0){
        $_SESSION['Message'] = $errors ;
    }else{

        $password = md5($password);

        ///////////db
        $sql   ="insert into user (name,email,password,user_type_id) values ('$name','$email','$password',$user_type_id)";
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
            Messages('Dashboard / User / Create');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" >

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name" placeholder="Enter Name">
            </div>

            <div class="form-group">
                <label for="exampleInputName">email</label>
                <input type="email" class="form-control" required id="exampleInputName" aria-describedby="" name="email" placeholder="Enter Email">
            </div>

            <div class="form-group">
                <label for="exampleInputName">password</label>
                <input type="password" class="form-control" required id="exampleInputName" aria-describedby="" name="password" placeholder="Enter Password">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">User Type</label>
                <select class="form-control" name="user_type_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($show)) {
                    ?>
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