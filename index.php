<?php

//include_once("includes/db_cred.php");
//$conn = mysqli_connect($hostname, $username, $password);
//
//$asdf = mysqli_query($conn, "SHOW TABLES FROM myensemble");
//var_dump(mysqli_fetch_assoc($asdf));
//var_dump(mysqli_fetch_assoc($asdf));
//var_dump(mysqli_fetch_assoc($asdf));
//
//
////var_dump($conn);
//
//mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<title>My Ensemble</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>

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
        background-image: linear-gradient(to right, black 0%, rgb(30,30,30) 100%);
    }

</style>


<!-- Header -->
<?php include_once("C:/wamp64/www/MyEnsemble/includes/header.php"); ?>

<!-- Page content -->
<div class="content" style="max-width:2000px;margin-top:46px">

    <div class="w3-center">
        <br>
        <h1 class="w3-wide" style="font-size: 2.5em">MY ENSEMBLE</h1>
        <p class="w3-opacity"><i>For the aspiring musician.</i></p>
    </div>
  <!-- My Ensemble -->
  <div class="w3-container w3-content w3-center style="max-width:800px" id="band">
      <div class="w3-opacity">
          <div class="file">
              <br>
              <p>Music file goes here</p>
              <br>
          </div>
          <div class="file">
              <br>
              <p>Music file goes here</p>
              <br>
          </div>
          <div class="file">
              <br>
              <p>Music file goes here</p>
              <br>
          </div>
          <div class="file">
              <br>
              <p>Music file goes here</p>
              <br>
          </div>
      </div>
  </div>

<!-- Footer -->
<?php include_once("C:/wamp64/www/MyEnsemble/includes/footer.php"); ?>

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
  if (myIndex > x.length) {myIndex = 1}
  x[myIndex-1].style.display = "block";
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
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>
