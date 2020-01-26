<?php

// Includes
include_once("db_cred.php");

// Session handling
session_start();

// Database connection
$conn = mysqli_connect($hostname, $username, $password);

// Didn't receive a username or password
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header("Location: ../user_portal.php");
}

// Escape username, hash password
$user = mysqli_escape_string($conn, $_POST['username']);
$hash = hash('sha256', $_POST['password']);
$skill = mysqli_escape_string($conn, $_POST['skill']);

// Query for matching hash and user
$user_query = mysqli_query($conn, "INSERT INTO myensemble.user 
                                            SET username = '" . $user . "',
                                            hash = '" . $hash . "',
                                            skill = '" . $skill . "'");

// Insert failure
if ($user_query === false) {
    header("Location: ../user_portal.php?error");
}
// Insert success
else {
    $_SESSION['username'] = $user;
    header("Location: ../index.php");
}
