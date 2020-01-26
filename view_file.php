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

// Query for comments
$comment_query = mysqli_query($conn, "SELECT c.comment_text, u.username FROM myensemble.comment c
                                                INNER JOIN myensemble.user u ON c.posting_user = u.user_id
                                                WHERE file_id = '" . $id . "'
                                                ORDER BY date DESC");
$comments = array();
while ($row = mysqli_fetch_assoc($comment_query)) {
    $comments[] = $row;
}

// Leaving a comment
if (isset($_POST) && isset($_POST['text'])) {
    $comment = mysqli_escape_string($conn, $_POST['text']);

    mysqli_query($conn, "INSERT INTO myensemble.comment
                                    SET file_id='" . $id . "',
                                    posting_user='" . $_SESSION['user_id'] . "',
                                    rating='0',
                                    comment_text='" . $comment . "',
                                    date=NOW()");

    // Close database connection
    mysqli_close($conn);

    // Refresh page
    header("Location: " . $_SERVER['PHP_SELF'] . "?user=$user&id=$id");
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            color: black;
        }

        .content {
            background-image: url('img/index_background.jpg');
            background-size: cover;
        }

        .file {
            border-radius: 25px;
            background: whitesmoke;
            width: 100%;
            margin: 2em;
            color: black;
        }

        .w3-wide {
            background-color: black;
            background-image: linear-gradient(to right, black 0%, rgb(30, 30, 30) 100%);
        }

    </style>
</head>
<body>
<br/><br/>
<div class="container">

    <div class="w3-center" style="color:white">
        <br>
        <h1 class="w3-wide font-weight-bold"><?= $file['title'] ?></>
    </div>


    <h2>User: <a href="submissions.php?user=<?= $user ?>"><?= $file['username'] ?></a></h2>
    <h3>Uploaded: <?= $file['date'] ?></h3>
    <h3>Rating: <?= $file['rating'] ?></h3>
    <div class="w3-center">
        <?php
        // Display audio player
        $audio = "files/" . $id . ".mp3";
        echo "<audio controls>
             <source src='" . $audio . "' type='audio/mp3'>
          </audio>";
        ?>
        <br><br><br>

        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>?user=<?= $user ?>&id=<?= $id ?>">
            <label for="text">Leave feedback:</label><br/>
            <textarea style="width: 50em; height: 10em" id="text" name="text" maxlength="500"></textarea><br/>
            <input type="submit">
        </form>

        <br/><br/>
        <h3 class="w3-center">Feedback</h3>
        <table class="table">
            <tr>
                <th>User</th>
                <th>Comment</th>
            </tr>
            <?php
            foreach ($comments as $comment) {
                echo "<tr>
                        <td>" . $comment['username'] . "</td>
                        <td>" . $comment['comment_text'] . "</td>
                    </tr>";
            } ?>
        </table>
    </div>
</div>
</body>
</html>
