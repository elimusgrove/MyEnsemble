<?php

// Includes
include_once("includes/db_cred.php");
include_once("includes/header.php");

// Database connection
$conn = mysqli_connect($hostname, $username, $password);

// Query for music uploads
$music_query = mysqli_query($conn, "SELECT f.title, u.username, u.user_id, f.category, f.rating, f.file_id
                                            FROM myensemble.file f 
                                            INNER JOIN myensemble.user u ON u.user_id = f.posting_user
                                            ORDER BY f.rating DESC 
                                            LIMIT 10");

// Populate music information array
while ($music_info[] = mysqli_fetch_assoc($music_query));

// Close database connection
mysqli_close($conn);
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

    <style>
        body {
            color: white;
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
<div class="content" style="max-width:2000px;margin-top:46px">

    <div class="w3-center">
        <br>
        <h1 class="w3-wide font-weight-bold" style="font-size: 2.5em">MY ENSEMBLE</h1>
        <p class="font-weight-bold"><i>For the aspiring musician.</i></p>
    </div>

    <div class="w3-container w3-content w3-center" style="max-width:800px">
        <h2 class="w3-wide font-weight-bold" style="font-size: 1.5em">Top Posts</h2>
        <div class="w3-opacity">
            <table style="width: 100%" class="file">
                <tr>
                    <th>Title</th>
                    <th>User</th>
                    <th>Category</th>
                    <th>Rating</th>
                </tr>
                <?php
                foreach ($music_info as $file) {
                    echo "<tr>
                            <td><a href=view_file.php?user=" . $file['user_id'] . "&id=" . $file['file_id'] . ">" . $file['title'] . "</a></td>
                            <td><a href=submissions.php?user=" . $file['user_id'] . ">" . $file['username'] . "</a></td>
                            
                            <td>" . $file['category'] . "</td>
                            <td>" . $file['rating'] . "</td>
                        </tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once("includes/footer.php"); ?>

    <script>
        // Automatic Slideshow - change image every 4 seconds
        var myIndex = 0;
        carousel();

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndex++;
            if (myIndex > x.length) {
                myIndex = 1
            }
            x[myIndex - 1].style.display = "block";
            setTimeout(carousel, 4000);
        }

        // Used to toggle the menu on small screens when clicking on the menu button
        function myFunction() {
            var x = document.getElementById("navDemo");
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
        }

        // When the user clicks anywhere outside of the modal, close it
        var modal = document.getElementById('ticketModal');
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
