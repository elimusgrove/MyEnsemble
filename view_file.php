<?php
include_once("includes/db_cred.php");
$conn = mysqli_connect($hostname, $username, $password);

$id = $_GET["id"];


$file_query = mysqli_query($conn, "SELECT * FROM myensemble.file WHERE file_id =" . $id);

var_dump(mysqli_fetch_assoc($file_query));

mysqli_close($conn);


