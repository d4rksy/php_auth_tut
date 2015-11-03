<?php

/**
 *  Note: password_hash and password_verify were added in PHP 5.5.0
 *  if using an older php version please see: 
 *  https://github.com/ircmaxell/password_compat instead.
 *
 *  PASSWORD_DEFAULT is currently the same as PASSWORD_BCRYPT this might change
 *  when a better hashing algorithm has proven it self.
 */

// Set work factor for bcrypt
$options = ["cost" => 14];

function hashPassword($password, $options) {
    // return password_hash($password, PASSWORD_BCRYPT, $options);
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