<?php

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
    <form method="post" action="">

    </form>
</body>
</html>
