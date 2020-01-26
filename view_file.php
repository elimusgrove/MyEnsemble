<?php

// Database connection
$conn = mysqli_connect($hostname, $username, $password);

// AJAX handling
$ajax_action = $_POST['ajax_action'];
if (isset($ajax_action) && $ajax_action == 'vote') {

    // Vars
    $upvoting = mysqli_escape_string($conn, $_POST['upvote']);
    $file_id = mysqli_escape_string($conn, $_POST['file_id']);
    $user_id = mysqli_escape_string($conn, $_POST['user_id']);

    // Determine if already voted on
    $voted_query = mysqli_query($conn, "SELECT upvote
                                                FROM myensemble.rated_file
                                                WHERE file_id = '" . $file_id . "'
                                                AND user_id = '" . $user_id . "'");
    $voted_results = mysqli_fetch_assoc($voted_query);
    $voted = mysqli_num_rows($voted_query) > 0 ? true : false;
    $upvoted = $voted_results['upvote'];

    // Haven't voted
    if (!$voted) {
        mysqli_query($conn, "INSERT INTO myensemble.rated_file
                                        SET file_id = '" . $file_id . "',
                                        rating_user = '" . $user_id . "',
                                        upvote = '" . $upvoting . "'");
    }



    echo json_encode($voted);
    exit;
}

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
    <button type="button" onclick="vote(true)">Upvote</button>
    <button type="button" onclick="vote(false)">Downvote</button>
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

<script type="text/javascript">
    function vote(upvote) {
        $.ajax({
            url : "<?= $_SERVER['PHP_SELF'] ?>",
            type : 'POST',
            data : {
                'ajax_action' : 'vote',
                'upvote' : upvote,
                'user_id' : <?= $_SESSION['user_id'] ?>,
                'file_id' : <?= $id ?>
            },
            dataType:'json',
            success : function(data) {
                alert('Data: '+data);
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
            }
        });
    }
</script>
</html>
