<?php
////////// Connection DB ////////////
require "partials/db.php" ;

////////// To use Any Function //////////
require "partials/functions.php" ;

#####################################################################

///////////////// Get Data From Subscribe Table 
$sql = "select * from subscribe" ;
$sub_op = doQuery($sql);

####################################################################

if ($_SERVER['REQUEST_METHOD']=="POST") {
    # get data from inputs
    $name = cleanData($_POST['name']);
    $email = cleanData($_POST['email']);
    $password = cleanData($_POST['password']);
    $gender = cleanData($_POST['gender']);
    $address = cleanData($_POST['address']);
    $sub_id = cleanData($_POST['sub_id']);

    $errors = [];

    /////////Validate Email
    if (!validate($name, 'reqiured')) {
    # code...
    $errors['Name'] = 'Field Required';
    } elseif (!validate($name, 'min',3)) {
    $errors['Name'] = 'Must Be >= 3 chars';
    }
    
    
    /////////Validate Email
    if (!validate($email, 'reqiured')) {
        # code...
        $errors['Email'] = 'Field Required';
    } elseif (!validate($email, 'email')) {
        $errors['Email'] = 'Invalid Format';
    }

    ////////////Validate Password
    if (!validate($password, 'reqiured')) {
        # code...
        $errors['Password'] = 'Field Required';
    } elseif (!validate($password, 'min')) {
        $errors['Password'] = 'Field Length Must Be > = 6 char';
    }

    ////////////Validate gender
    if (!validate($gender, 'reqiured')) {
        # code...
        $errors['Gender'] = 'Field Required';
    }

    ////////////Validate Password
    if (!validate($address, 'reqiured')) {
        # code...
        $errors['Address'] = 'Field Required';
    } elseif (!validate($address, 'min')) {
        $errors['Address'] = 'Field Length Must Be > = 6 char';
    }

    ////////////Validate Password
    if (!validate($sub_id, 'reqiured')) {
        # code...
        $errors['Subscribe Type'] = 'Field Required';
    } elseif (!validate($sub_id, 'int')) {
        $errors['Subscribe Type'] = 'Must be int';
    }



    #check errors
    if (count ($errors) > 0 ) {
        foreach($errors as $key => $value){
            echo "<script> window.alert('". $key ." : " . $value . "')</script>";
        }
    }else{
        #encript password
        $password = md5($password);

        ###### inser data To DB
        $sql = "insert into user (name , email , password , user_type_id) values ('$name', '$email', '$password', 7 )";
        $create_user = mysqli_query($connection,$sql);

        ######Check Create
        if ($create_user) {
            # code...
            $user_id = mysqli_insert_id($connection);
            $sql = "insert into member ( address , gender , active , user_id , subscribe_id ) values ('$address', '$gender', 0 , $user_id , $sub_id )";
            $create_member = mysqli_query($connection,$sql);
            if ($create_member) {
                echo "<script> window.alert(' Done Membership ')</script>";

            }else{
                echo "<script> window.alert(' Error in Create Member ')</script>";
            }

        }else{
            echo "<script> window.alert(' Error in Create User ')</script>";
        }
    }

    #### close DB #########
    mysqli_close($connection);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="../main.css">
</head>
<body>
	<section class="login">
		<div class="login_box" style="height: 90vh;">
			<div class="left">
				<div class="top_link"><a href="../index.php">
                <img src="https://drive.google.com/u/0/uc?id=16U__U5dJdaTfNGobB_OpwAJ73vM50rPV&export=download" alt="">Return home</a></div>
				<div class="contact">
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" method="POST">
						<h3 style="margin-bottom: 10px;">MEMBERSHIP</h3>
						<input type="text" placeholder="Name" name="name">
                        <input type="text" placeholder="Email" name="email">
						<input type="password" placeholder="Password" name="password">
                        <select name="gender" > 
                            <option value="" selected> Gender </option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <input type="text" placeholder="Address" name="address">
                        <select name="sub_id">
                            <option value="" selected> Subscribe Type </option>
                            <?php while($raw = mysqli_fetch_assoc($sub_op)){ ?> 
                            <option value="<?php echo $raw['id']; ?>"><?php echo $raw['type']; ?></option>
                            <?php } ?>
                        </select>


						<button class="submit" style="margin-top: 20px;">Sign Up</button>
					</form>
				</div>
			</div>
			<div class="right">
				<div class="right-text">
					<h2>EL KA7IAN</h2>
					<h5>GYM</h5>
				</div>
				<div class="right-inductor">
                <img src="https://lh3.googleusercontent.com/fife/ABSRlIoGiXn2r0SBm7bjFHea6iCUOyY0N2SrvhNUT-orJfyGNRSMO2vfqar3R-xs5Z4xbeqYwrEMq2FXKGXm-l_H6QAlwCBk9uceKBfG-FjacfftM0WM_aoUC_oxRSXXYspQE3tCMHGvMBlb2K1NAdU6qWv3VAQAPdCo8VwTgdnyWv08CmeZ8hX_6Ty8FzetXYKnfXb0CTEFQOVF4p3R58LksVUd73FU6564OsrJt918LPEwqIPAPQ4dMgiH73sgLXnDndUDCdLSDHMSirr4uUaqbiWQq-X1SNdkh-3jzjhW4keeNt1TgQHSrzW3maYO3ryueQzYoMEhts8MP8HH5gs2NkCar9cr_guunglU7Zqaede4cLFhsCZWBLVHY4cKHgk8SzfH_0Rn3St2AQen9MaiT38L5QXsaq6zFMuGiT8M2Md50eS0JdRTdlWLJApbgAUqI3zltUXce-MaCrDtp_UiI6x3IR4fEZiCo0XDyoAesFjXZg9cIuSsLTiKkSAGzzledJU3crgSHjAIycQN2PH2_dBIa3ibAJLphqq6zLh0qiQn_dHh83ru2y7MgxRU85ithgjdIk3PgplREbW9_PLv5j9juYc1WXFNW9ML80UlTaC9D2rP3i80zESJJY56faKsA5GVCIFiUtc3EewSM_C0bkJSMiobIWiXFz7pMcadgZlweUdjBcjvaepHBe8wou0ZtDM9TKom0hs_nx_AKy0dnXGNWI1qftTjAg=w1920-h979-ft" alt="">
                </div>
			</div>
		</div>
	</section>
</body>
</html>