<?php

// Include helper scripts
require "database.php";
require "password.php";

// Lets see if our database exists if not, lets create it
if (!tableExists($conn, 'guestbook')) {
    createGuestbookTable($conn);
}

// Initiate the Session so we can access the $_SESSION global variable in this script.
session_start();


// Check if user has already logged in, if true redirect to index.php
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

// Check if Ajax request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
    //request is ajax
    $commentList = fetchGuestbook($conn);
    return json_encode($commentList);
}

$emptyError = false;

// Check for $_POST
if (isset($_POST["commentSubmit"])) {
    // Let's not submit empty comments
    if ($_POST["comment"] != "") {
        // Populate the $data array for insertion
        $data["comment"] = $_POST["comment"];
        $data["timestamp"] = time("now");
        $data["user_id"] = $_SESSION["user"]["user_id"];
        
        insertComment($conn, $data);
    }
    else {
        $emptyError = true;
    }
}

$commentList = fetchGuestbook($conn);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="custom.css">

	    
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
</head>
<body>
	<nav class="navbar navbar-default">
    </nav>
	<div class="container">
        <h1 class="page-title">
		  Comments
        </h1>
        <div class="col-md-6">
            <form id="loginForm" name="commentForm" method="POST">
                <div class="form-group">
                    <textarea class="form-control" name="comment" placeholder="Leave a comment.."></textarea>
                <?php if ($emptyError == true) : ?>
                    <div class="alert alert-danger">Passwords do not match.</div>
                <?php endif;?>
                </div>
                <div class="form-group">
                    <button name="commentSubmit" class="btn btn-md btn-success">Post</button>
                </div>
            </form>
            <div class="col-md-12">
                <?php if ($commentList !== false ) : ?>
                <?php foreach($commentList as $comment) : ?>
                <div class="panel panel-default comment-panel">
                    <div class="panel-body">
                        <?php echo $comment['comment']; ?>
                    </div>
                    <div class="panel-footer comment-footer">
                        <?php echo gmdate("M d Y H:i:s",$comment['timestamp'])." by ".$comment["username"]; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <h3><small>No comments yet :(</small></h3>
                <?php endif; ?>
            </div>
        </div>
	</div>
</body>
</html>


