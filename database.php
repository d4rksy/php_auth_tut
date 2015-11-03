<?php

// $conn = new PDO('mysql:host=localhost;dbname=yourdbname', 'username', 'password');
$conn = new PDO('mysql:host=localhost;dbname=test', 'root', '');


// Grab data relating to username
function getUser($username,$conn) {
    $query = $conn->prepare("SELECT * FROM profile WHERE username = :username LIMIT 1");
    $query->bindParam(":username", $username);
    $query->execute();
    $profile = $query->fetch(PDO::FETCH_ASSOC);
    return $profile;
}

function insertUser($data,$conn) {
    $query = $conn->prepare("INSERT INTO profile (username, password, email) VALUES (:username, :password, :email)");
    $query->bindParam(":username", $data["username"]);
    $query->bindParam(":password", $data["password"]);
    $query->bindParam(":email", $data["email"]);
    $query->execute();
}


?>