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

function createUserTable($conn) {
    $query = $conn->prepare("CREATE TABLE `profile` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(45) DEFAULT NULL,
    `password` varchar(128) DEFAULT NULL,
    `active` varchar(45) DEFAULT NULL,
    `email` varchar(45) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");
    $query->execute();
}

function createGuestbookTable($conn) {
    $query = $conn->prepare("CREATE TABLE `guestbook` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `comment` TEXT DEFAULT NULL,
    `timestamp` INT(11) DEFAULT NULL,
    `user_id` INT(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");
    $query->execute();
}

function createShopTable($conn) {
    $query = $conn->prepare("CREATE TABLE `shop` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `items` TEXT DEFAULT NULL,
    `timestamp` INT(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");
    $query->execute();
}

function saveShop($conn, $new_cycle, $timestamp , $new) {
    if ($new == true) {
        $query = $conn->prepare("INSERT INTO shop (items, timestamp) VALUES (:items, :timestamp)");
        $query->bindParam(":items", $new_cycle);
        $query->bindParam(":timestamp", $timestamp);
        $query->execute();
    } else {
        $query = $conn->prepare("UPDATE shop SET items = :items, timestamp = :timestamp WHERE id = 1");
        $query->bindParam(":items", $new_cycle);
        $query->bindParam(":timestamp", $timestamp);
        $query->execute();
    }
}

function getShop($conn) {
    $query = $conn->prepare("SELECT * FROM shop LIMIT 1");
    $query->execute();
    $shop = $query->fetch(PDO::FETCH_ASSOC);
    return $shop;
}

function insertComment($conn, $data) {
    $query = $conn->prepare("INSERT INTO guestbook (comment, timestamp, user_id) VALUES (:comment, :timestamp, :user_id)");
    $query->bindParam(":comment", $data["comment"]);
    $query->bindParam(":timestamp", $data["timestamp"]);
    $query->bindParam(":user_id", $data["user_id"]);
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

function fetchGuestbook($conn) {
    $query = $conn->prepare("SELECT profile.username, guestbook.comment, guestbook.timestamp FROM guestbook JOIN profile on profile.id=guestbook.user_id ORDER BY guestbook.timestamp DESC");
    $query->execute();
    $guestbook = $query->fetchAll();
    return $guestbook;
}

?>