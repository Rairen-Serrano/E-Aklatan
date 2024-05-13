<?php
session_start();

// Update time_log_out for the logged-out user
if (isset($_SESSION['SESSION_EMAIL'])) {
    include("dbconnect.php");

    // Get the email of the logged-out user
    $email = $_SESSION['SESSION_EMAIL'];

    // Update time_log_out with the current timestamp
    $update_time_sql = "UPDATE users SET time_log_out = NOW() WHERE email = '{$email}'";
    mysqli_query($dbconnect, $update_time_sql);

    mysqli_close($dbconnect);
}

// Unset and destroy the session
session_unset();
session_destroy();

// Redirect to the login page
header("Location: login.php");
?>
