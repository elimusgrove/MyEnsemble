<?php

// Includes
include_once("includes/db_cred.php");
include_once("includes/header.php");

// Session handling
session_start();

// User not logged in, this page requires login
if (!isset($_SESSION['user_id'])) {
    header("Location: user_portal.php?login");
}

// Uploaded file handling
if (isset($_GET['action']) && $_GET['action'] === "upload") {
    echo "<br/><br/><br/><br/><br/><br/><br/><br/>";
}
?>

<!DOCTYPE html>
<html>
<body>
    <form method="post" action="<?= $_SERVER['PHP_SELF']?>?action=upload">
        <br/><br/><br/>
        <label for="title">Title:</label><br/>
        <input type="text" id="title" name="title">

        <br/><br/>

        <label for="category">Instrument Category:</label><br/>
        <select id="category" name="category">
            <option value="bowed_strings">Bowed Strings</option>
            <option value="keyboard">Keyboard</option>
            <option value="woodwinds">Woodwinds</option>
            <option value="brass">Brass</option>
            <option value="vocal">Vocal</option>
            <option value="percussion">Percussion</option>
            <option value="other">Other</option>
        </select>

        <br/><br/>
        <input type="submit">
    </form>
</body>
</html>
