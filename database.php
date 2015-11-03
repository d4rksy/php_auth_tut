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

function createTable($conn) {
    $query = $conn->prepare("CREATE TABLE `profile` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(45) DEFAULT NULL,
    `password` varchar(128) DEFAULT NULL,
    `active` varchar(45) DEFAULT NULL,
    `email` varchar(45) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;");
    $query->execute();
}


function tableExists($conn, $table) {

    // Try a select statement against the table
    // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
    try {
        $result = $conn->query("SELECT 1 FROM $table LIMIT 1");
    } catch (Exception $e) {
        // We got an exception == table not found
        return FALSE;
    }

    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
}

?>