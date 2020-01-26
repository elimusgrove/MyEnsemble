<?php

// Includes
include_once("includes/header.php");

// Session handling
session_start();

// Logging out
if (isset($_GET['logout'])) {
    session_unset();
}

// Already logged in
if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <form method="post"
        <?php
        if (isset($_GET['login'])) {
            echo "action=\"includes/login.php\"";
        } else {
            echo "action=\"includes/register.php\"";
        } ?>>
        <br/><br/><br/>
        <label for="username">Username:</label>
        <br/>
        <input id="username" name="username" type="text">

        <br/><br/>

        <label for="password">Password:</label>
        <br/>
        <input id="password" name="password" type="password">

        <br/>

        <?php if (isset($_GET['login'])) { ?>
            <br/>
            <input type="submit" value="Login" formaction="includes/login.php">
        <?php } else { ?>
            <br/>
            <label for="skill">Skill Level:</label>
            <select id="skill" name="skill">
                <option value="chopsticks">Chopsticks</option>
                <option value="amateur">Amateur</option>
                <option value="proficient">Proficient</option>
                <option value="virtuoso">Virtuoso</option>
            </select>
            <br/><br/>
            <input type="submit" value="Register" formaction="includes/register.php">
        <?php } ?>

    </form>
</body>
</html>
