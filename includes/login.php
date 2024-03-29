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

// Query for matching hash and user
$user_query = mysqli_query($conn, "SELECT user_id 
                                            FROM myensemble.user
                                            WHERE username = '" . $user . "' 
                                                AND hash = '" . $hash . "'");

// Close connection
mysqli_close($conn);

// Invalid user
if (mysqli_num_rows($user_query) <= 0) {
    header("Location: ../user_portal.php?login&error");
}
// Valid user
else {
    $row = mysqli_fetch_assoc($user_query);
    $_SESSION['user_id'] = $row['user_id'];
    header("Location: ../index.php");
}
