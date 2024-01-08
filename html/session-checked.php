<?php
    include 'dbconnect.php';
    session_start();

    //Check if the user is logged in
    if (!isset($_SESSION['UserID'])) {
        //If not logged in, redirects to the login page
        header("Location: login.php");
        exit;
    }
?>