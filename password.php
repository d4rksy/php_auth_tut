<?php

//Set work factor for bcrypt
$options = [
    "cost" => 14,
    ];

function hashPassword($password, $options) {
    return password_hash($password, PASSWORD_DEFAULT, $options);
}

function verifyPassword($password, $hash) {
    if (password_verify($password, $hash)) {
        return true;
    }
    else {
        return false;
    }
}