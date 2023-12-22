<!-- This is where the profile of each users display -->

<?php 
    session_start();
    if(!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: login.php");
        die();
    }

    include 'dbconnect.php';

    $users_query = mysqli_query($dbconnect, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($users_query) > 0) {
        $users_row = mysqli_fetch_assoc($users_query);

        echo "Welcome ". $users_row['name'] . "<a href='logout.php'>Logout</a>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="../css/style.css">

    <!--Javascript link here-->
    <script defer src="../js/script.js" ></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="../js/jquery-3.7.1.js" defer></script>

    <title>Profile Page</title>
    
</head>
<body>
    <!--one line code for navbar-->
    <div id="navbar-placeholder"></div>


    <!--one line code for footer-->
    <div id="footer-placeholder"></div>
</body>
</html>