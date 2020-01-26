<?php

// Includes
include_once("includes/db_cred.php");

// Session setup
session_start();

// Database connection
$conn = mysqli_connect($hostname, $username, $password);

// Given id
$id = mysqli_escape_string($conn, $_GET['id']);
$user = mysqli_escape_string($conn, $_GET['user']);

// No file given
if ($id == null) {
    header("Location: submissions.php?user=" . $_SESSION['user_id']);
}

// Query for file
$file_query = mysqli_query($conn, "SELECT * FROM myensemble.file WHERE file_id =" . $id);
$file = mysqli_fetch_assoc($file_query);

// File doesn't exist
if (mysqli_num_rows($file_query) <= 0) {
    header("Location: submissions.php?user=$user");
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>

</body>
</html>
