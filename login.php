<?php
    //include shit
	require "database.php";
    require "password.php";
    
    session_start();
    
    if (isset($_SESSION["user"])) {
        header("Location: index.php");
    }


    $passError = false;

    //Check if POST
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        //Check if a user exists
        if ($user = getUser($username, $conn)) {
            //Check if passwords match. If you get an error here, check that your password column
            //is set to something as large as VARCHAR(128), 45 is definitely too small.
            if(verifyPassword($password, $user["password"])) {
                //Create a session
                $_SESSION["user"]["user_id"] = $user["id"];
                $_SESSION["user"]["user_email"] = $user["email"];
                $_SESSION["user"]["user_name"] = $user["username"];
                //Redirect to index on login
                header('Location: http://localhost/authtest/index.php');
            } else {
                $passError = true;
            }
        } else {
            $passError = true;
        }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
</head>
<body>
	<nav class="navbar navbar-default">
    </nav>
	<div class="container">
        <h1 class="page-title">
            
		  Login
        </h1>
        
        <div class="login-wrapper">
            
            <h3><small>Please enter your details below</small></h3>
            
            <div class="col-md-4">
                <form id="loginForm" name="loginForm" method="POST">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input name="username" class="form-control" type="text" required/>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input name="password" class="form-control" type="password" required/>
                    </div>
                    <?php if ($passError == true) : ?>
                        <div class="alert alert-danger">Incorrect username or password.</div>
                    <?php endif;?>
                    <div class="form-group">
                        <button id="loginBtn" class="btn btn-success btn-md">Login</button>                     </div>
                    <div class="form-group">
                        <a href="register.php">Not registered?</a>
                    </div>
                </form>
                
            </div>
            
        </div>
        
	</div>
</body>
</html>


