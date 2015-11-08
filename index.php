<?php

session_start();

// Check if user is logged in, if not redirect to login.php
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
    <!-- Get some jQuery in here -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <script src="comment.js"></script>
    <link rel="stylesheet" href="custom.css">
</head>
<body>
    <nav class="navbar navbar-default">
        <ul class="navbar-nav nav">
            <li>
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <!-- Greet the user by username -->
        <h3>Hello <?php echo $_SESSION["user"]["user_name"]; ?></h3>
        <div id="commentContainer" class="col-md-12">
            
        </div>
    </div>
</body>
</html>