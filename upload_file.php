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

// Database connection
$conn = mysqli_connect($hostname, $username, $password);

// Uploaded file handling
if (isset($_FILES) && isset($_FILES['music_sample']) && $_FILES['music_sample']['error'] === 0) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Get id of file to insert (file location)
    $file_id_query = mysqli_query($conn, "SELECT MAX(file_id) as id
                                                    FROM myensemble.file");
    $file_id_result = mysqli_fetch_assoc($file_id_query);
    $file_id = $file_id_result['id'] + 1;

    // Put uploaded file in the files folder
    $moved = move_uploaded_file($_FILES['music_sample']['tmp_name'], "files/" . $file_id . ".mp3");

    // Insert new file
    if ($moved === true) {
        mysqli_query($conn, "INSERT INTO myensemble.file
                                        SET posting_user='" . $_SESSION['user_id'] . "',
                                        title='" . $title . "',
                                        rating='0',
                                        category='" . $category . "',
                                        location='files/" . $file_id . ".mp3',
                                        date=CURRENT_TIMESTAMP()");

        // TODO: Redirect to view the file
    }
    else {
        echo "<br/><br/>Upload error!";
        exit(0);
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<body>
    <form method="post" enctype="multipart/form-data">
        <br/><br/><br/>
        <label for="title">Title:</label><br/>
        <input type="text" id="title" name="title" maxlength=50, required>

        <br/><br/>

        <label for="category">Instrument Category:</label><br/>
        <select id="category" name="category" required>
            <option value="bowed_strings">Bowed Strings</option>
            <option value="keyboard">Keyboard</option>
            <option value="woodwinds">Woodwinds</option>
            <option value="brass">Brass</option>
            <option value="vocal">Vocal</option>
            <option value="percussion">Percussion</option>
            <option value="other">Other</option>
        </select>

        <br/><br/>

        <input type="file" name="music_sample" accept=".mp3" required>

        <br/><br/>
        <input type="submit">
    </form>
</body>
</html>
