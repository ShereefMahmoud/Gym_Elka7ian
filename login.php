<?php
////////// Connection DB ////////////
require "partials/connectionDB.php" ;

////////// To use Any Function //////////
require "partials/functions.php" ;

if ($_SERVER['REQUEST_METHOD']=="POST") {
    # get data from inputs
    $email = cleanData($_POST['email']);
    $password = cleanData($_POST['password']);

    $errors = [];

    #validate name
    if (empty($email)) {
        $errors['email'] = ' Field Required';
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Not Valid';
    }

    #validate name
    if (empty($password)) {
        $errors['pasword'] = ' Field Required';
    }elseif(strlen($password) < 8){
        $errors['password'] = ' must be more than 8 ';
    }

    #check errors
    if (count ($errors) > 0 ) {
        foreach($errors as $key => $value){
            echo "<script> window.alert('". $key ." : " . $value . "')</script>";
        }
    }else{
        #encript password
        //$password = md5($password);

        ###### selsct data from DB
        $sql = "select * from user where email = '$email' and password = '$password' ";
        $checkLogin = mysqli_query($connection,$sql);

        ######Check Data 
        if (mysqli_num_rows($checkLogin) == 1 ) {
            $userData = mysqli_fetch_assoc($checkLogin);
            $_SESSION['user'] = $userData;


            ####check privilage ######
            if ($_SESSION['user']['user_type_id'] == 1 ) {
                # redirect to manager
                header('location: manager/index.php');
            }elseif($_SESSION['user']['user_type_id'] == 2 ){

                # redirect to coach
                header('location: coach/index.php');
            }else{

                # redirect to member
                header('location: member/index.php');
            }
        }else{
            echo "<script> window.alert('Please Try again , Your Email or Password Not Valid .')</script>";
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
<link rel="stylesheet" href="main.css">
</head>
<body>
	<section class="login">
		<div class="login_box">
			<div class="left">
				<div class="top_link"><a href="index.php">
                <img src="https://drive.google.com/u/0/uc?id=16U__U5dJdaTfNGobB_OpwAJ73vM50rPV&export=download" alt="">Return home</a></div>
				<div class="contact">
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ; ?>" method="POST">
						<h3>SIGN IN</h3>
						<input type="text" placeholder="Email" name="email">
						<input type="password" placeholder="PASSWORD" name="password">
						<button class="submit">LET'S GO</button>
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