<?php

// Includes
include_once("includes/db_cred.php");

// Database connection
$conn = mysqli_connect($hostname, $username, $password);

// Given id
$id = mysqli_escape($conn, $_GET["id"]);

// Query for file
$file_query = mysqli_query($conn, "SELECT * FROM myensemble.file WHERE file_id =" . $id);
$file_result = mysqli_fetch_assoc($file_query);

var_dump($file_result);

// Close database connection
mysqli_close($conn);
