<?php
//include shit
require "database.php";
require "password.php";

$passError = false;
$userError = false;

//Check if POST
if (isset($_POST["registrationSubmit"])) {
    //Check if username was entered
    if (isset($_POST["username"])) {
        $username = $_POST["username"];
        //PDO defaults to boolean false on empty queries which is what we are looking for
        if (getUser($_POST["username"],$conn) == false) {
            //Check if passwords match
            if ($_POST["password"] === $_POST["password-confirm"]) {
                //Put all the relevant user information in to the data array
                $data["username"]   = $_POST["username"];
                $data["email"]      = $_POST["email"];     
                //Hash the password (see password.php)
                $data["password"]   = hashPassword($_POST["password"], $options);
                //Insert data in to database (see database.php)
                insertUser($data, $conn);
                //redirect to login
                header("Location: login.php");
            }  
            else {
                $passError = true;
            }
        } 
        else {
            $userError = true;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
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
            Register
        </h1>
        
        <div class="login-wrapper">
            
            <h3><small>Please enter your details below.</small></h3>
            
            <div class="col-md-4">
                <form id="loginForm" name="registrationForm" method="POST">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input name="username" class="form-control" type="text" required/>
                    </div>
                    <?php if ($userError == true) : ?>
                        <div class="alert alert-danger">Username is already in use.</div>
                    <?php endif;?>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input name="email" class="form-control" type="email" required/>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input name="password" class="form-control" type="password" required/>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Confirmation</label>
                        <input name="password-confirm" class="form-control" type="password" required/>
                    </div>
                    <?php if ($passError == true) : ?>
                        <div class="alert alert-danger">Passwords do not match.</div>
                    <?php endif;?>
                    <div class="form-group">
                        <button name="registrationSubmit" id="loginBtn" class="btn btn-success btn-md">Register</button>
                    </div>
                </form>
                
            </div>
            
        </div>
        
	</div>
</body>
</html>


