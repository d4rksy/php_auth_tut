<?php
// Initate the $_SESSION so we can access it, or in this case destroy it.
session_start();
// Unset the $_SESSION["user"] array, effectively logging the user out. 
unset($_SESSION["user"]);
// Redirect back to login.
header("Location:login.php");
?>