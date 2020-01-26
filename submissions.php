<?php

// Includes
include_once("includes/db_cred.php");
include_once("includes/header.php");

// Session handling
session_start();

// Database connection
$conn = mysqli_connect($hostname, $username, $password);

if (!isset($_SESSION['user_id'])) {
    header("Location: user_portal.php?login");
}

// Default to show the logged-in user's files
if (!isset($_GET['user'])) {
    header("Location: submissions.php?user=" . $_SESSION['user_id']);
}

// Get user id
$id = mysqli_escape_string($conn, $_GET['user']);

// Get username
$username_query = mysqli_query($conn, "SELECT username FROM myensemble.user
                                                WHERE user_id = '" . $id . "'");
$username_result = mysqli_fetch_assoc($username_query);

// Query for files posted by the given user
$file_query = mysqli_query($conn, "SELECT f.file_id, f.title, f.rating, f.category FROM myensemble.file f
                                            WHERE posting_user = '" . $id . "'");

// Populate files array
$files = array();
while ($row = mysqli_fetch_assoc($file_query)) {
    $files[] = $row;
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            color: white;
        }

        .w3-wide {
            background-color: black;
            background-image: linear-gradient(to right, black 0%, rgb(30, 30, 30) 100%);
        }

    </style>

</head>
<body>
<br><br>
<div class="w3-container container">

    <div class="w3-center">
        <br>
        <h1 class="w3-wide font-weight-bold"><?= $username_result['username'] ?>'s music</h1>
    </div>

    <?php if (mysqli_num_rows($file_query) > 0) { ?>

        <table class="table">
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Rating</th>
                <th>Link</th>
            </tr>
            <?php
            // Display each file with a link
            foreach ($files as $file) {
                echo "<tr>
                        <td>" . $file['title'] . "</td>
                        <td>" . $file['category'] . "</td>
                        <td>" . $file['rating'] . "</td>
                        <td style='color:blue'><a href=" . "view_file.php?user=" . $id . "&id=" . $file['file_id'] . ">View</a></td>
                    </tr>";
            }
            ?>
        </table>

    <?php } else {
        echo "<h3 class='text-center'>" . $username_result['username'] . " hasn't uploaded any files yet!</h3>";
    }
    ?>
</div>
</body>
</html>
