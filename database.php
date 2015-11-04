<?php

/**
 * @Author Juho 'd4rksy' Nikula
 * @Created 03/11/2015
 */

// $conn = new PDO('mysql:host=localhost;dbname=yourdbname', 'username', 'password');
$conn = new PDO('mysql:host=localhost;dbname=test', 'root', '');


/**
 * Get User data, hashed password, username, email etc.
 * @param  string $username 
 * @param  object PDO $conn
 * @return array 
 */
function getUser($username,$conn) {
    $query = $conn->prepare("SELECT * FROM profile WHERE username = :username LIMIT 1");
    $query->bindParam(":username", $username);
    $query->execute();
    $profile = $query->fetch(PDO::FETCH_ASSOC);
    return $profile;
}

/**
 * Get specific users comments with additional criteria if chosen.
 * @param  array (contains user_id and option array() for detailed searches)
 * @param  $conn PDO object
 * @return array (contains results)
 */
function getUserComments($data = array(),$conn) {
    if(isset($data["options"]["range"])) {
        $query = $conn->prepare("SELECT * FROM guestbook WHERE user_id = :user_id AND timestamp > :range");
        $query->bindParam(":user_id", $data["user_id"]);
        $query->bindParam(":range", $data["options"]["range"]);
        $query->execute();
        $userComments = $query->fetchAll();
        return $userComments;
    }
    else {
        $query = $conn->prepare("SELECT * FROM guestbook WHERE user_id = :user_id LIMIT 20");
        $query->bindParam(":user_id", $data["user_id"]);
        $query->execute();
        $userComments = $query->fetchAll();
        return $userComments;
    }
}

/**
 * Insert user data from registration or admin creation
 * @param  $data array containing user data
 * @param  $conn PDO object
 */
function insertUser($data,$conn) {
    $query = $conn->prepare("INSERT INTO profile (username, password, email) VALUES (:username, :password, :email)");
    $query->bindParam(":username", $data["username"]);
    $query->bindParam(":password", $data["password"]);
    $query->bindParam(":email", $data["email"]);
    $query->execute();
}

/**
 * Creates the user table if not present.
 * @param  object
 */
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

/**
 * Creates the Guestbook table if not present
 * @param  object
 */
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

/**
 * Inserts comment data
 * @param  object
 * @param  $data array containing comment data
 */
function insertComment($conn, $data) {
    $query = $conn->prepare("INSERT INTO guestbook (comment, timestamp, user_id) VALUES (:comment, :timestamp, :user_id)");
    $query->bindParam(":comment", $data["comment"]);
    $query->bindParam(":timestamp", $data["timestamp"]);
    $query->bindParam(":user_id", $data["user_id"]);
    $query->execute();
}

/**
 * Checks for the existance of a table by attempting to select the first column in the table. 
 * @param  $conn object
 * @param  $table string
 * @return $result boolean
 */
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

/**
 * @param  $conn object
 * @return $guestbook array
 */
function fetchGuestbook($conn) {
    $query = $conn->prepare("SELECT profile.username, guestbook.comment, guestbook.timestamp FROM guestbook JOIN profile on guestbook.user_id=profile.id ORDER BY guestbook.timestamp DESC");
    $query->execute();
    $guestbook = $query->fetchAll();
    return $guestbook;
}

?>