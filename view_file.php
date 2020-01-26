<?php

// Includes
include_once("includes/db_cred.php");
include_once("includes/header.php");

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
$file_query = mysqli_query($conn, "SELECT f.title, f.category, f.location, f.rating, f.date, u.username FROM myensemble.file f
                                            INNER JOIN myensemble.user u ON f.posting_user = u.user_id
                                            WHERE file_id =" . $id);
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
<br/><br/>
<h1><?= $file['title'] ?></h1>
<h2>User: <a href="submissions.php?user=<?= $user ?>"><?= $file['username'] ?></a></h2>
<h3>Uploaded: <?= $file['date'] ?></h3>
<h3>Rating: <?= $file['rating'] ?></h3>
<?php
// Display audio player
$audio = "files/" . $id . ".mp3";
echo "<audio controls>
         <source src='" . $audio . "' type='audio/mp3'>
      </audio>";
?>
</body>
</html>
