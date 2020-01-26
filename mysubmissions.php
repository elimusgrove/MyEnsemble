<?php

include_once("includes/db_cred.php");
$conn = mysqli_connect($hostname, $username, $password);

$asdf = mysqli_query($conn, "SHOW TABLES FROM myensemble");
var_dump(mysqli_fetch_assoc($asdf));
var_dump(mysqli_fetch_assoc($asdf));
var_dump(mysqli_fetch_assoc($asdf));


//var_dump($conn);

mysqli_close($conn);


?>

<!DOCTYPE html>
<html lang="en">
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<body>


<div class="w3-top">
    <div class="w3-bar w3-black w3-card">
        <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
        <a href="index.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
        <a href="#band" class="w3-bar-item w3-button w3-padding-large w3-hide-small">LOG IN</a>
        <a href="#tour" class="w3-bar-item w3-button w3-padding-large w3-hide-small">REGISTER</a>
        <a href="#contact" class="w3-bar-item w3-button w3-padding-large w3-hide-small">UPLOAD</a>
        <div class="w3-dropdown-hover w3-hide-small">
            <button class="w3-padding-large w3-button" title="More">USER <i class="fa fa-caret-down"></i></button>
            <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="mysubmissions.php" class="w3-bar-item w3-button">My Submissions</a>
                <a href="includes/header.php" class="w3-bar-item w3-button">Upload New Music</a>
            </div>
        </div>
        <a href="javascript:void(0)" class="w3-padding-large w3-hover-red w3-hide-small w3-right"><i class="fa fa-search"></i></a>
    </div>
</div>

<br><br>

<div class="w3-container">
    <h1> My Submissions</h1>

</div>



<div class="w3-container">
  
  <ul class="w3-ul w3-border w3-hoverable">
    <li>Test</li>
    <li>Test2</li>
    <li>Test3</li>
  </ul>
</div>




</body>
</html>
