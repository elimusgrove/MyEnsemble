<?php

// Session handling
session_start();

// Database connection
$conn = mysqli_connect($hostname, $username, $password);

// Submitting search term
if (isset($_POST['search_term'])) {
    $user_query = mysqli_query($conn, "SELECT u.user_id FROM myensemble.user u
                                                WHERE u.username LIKE '%" . $_POST['search_term'] . "%'");

    // Results for input user
    if (mysqli_num_rows($user_query) > 0) {
        $user_result = mysqli_fetch_assoc($user_query);
        $user = $user_result['user_id'];
        mysqli_close($conn);
        header("Location: submissions.php?user=" . $user);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Ensemble</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js">

    <link rel="icon" href="../img/quarter-rest-png-5.png" type="image/png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<div class="w3-top">
    <div class="w3-bar w3-black w3-card">
        <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right"
           href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i
                    class="fa fa-bars"></i></a>
        <a href="index.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
        <div class="w3-dropdown-hover w3-hide-small">
            <button class="w3-padding-large w3-button" title="More">USER <i class="fa fa-caret-down"></i></button>
            <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="submissions.php?user=<?= $_SESSION['user_id'] ?>" class="w3-bar-item w3-button">My
                    Submissions</a>
                <a href="upload_file.php" class="w3-bar-item w3-button">Upload New Music</a>
            </div>
        </div>
        <?php
        if (!isset($_SESSION['user_id'])) { ?>
            <a href="user_portal.php?login" class="w3-bar-item w3-button w3-padding-large w3-hide-small">LOG IN</a>
            <a href="user_portal.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">REGISTER</a>
        <?php } else { ?>
            <a href="user_portal.php?logout&login"
               class="w3-bar-item w3-button w3-padding-large w3-hide-small">LOGOFF</a>
        <?php } ?>

        <form method="post">
            <input name="search_term" class="w3-padding-large w3-hide-small w3-right" placeholder="search">
        </form>
    </div>
</div>
</body>