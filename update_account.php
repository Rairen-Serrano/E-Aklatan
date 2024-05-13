<?php
    session_start();

    // Include your database connection file
    include('dbconnect.php');

    // Get the user email from the session
    $user_email = $_SESSION['SESSION_EMAIL'];

    // Fetch user details from the database
    $user_query = "SELECT UserID FROM users WHERE email = ?";
    $user_stmt = mysqli_prepare($dbconnect, $user_query);
    mysqli_stmt_bind_param($user_stmt, 's', $user_email);
    mysqli_stmt_execute($user_stmt);
    $user_result = mysqli_stmt_get_result($user_stmt);

    if ($user_result && $user_row = mysqli_fetch_assoc($user_result)) {
        $userID = $user_row['UserID'];

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $middle_name = $_POST['middle_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $date_of_birth = $_POST['date_of_birth'];

            // Update user details in the account_details table
            $update_query = "UPDATE account_details SET
                            first_name = ?,
                            last_name = ?,
                            middle_name = ?,
                            email = ?,
                            phone_number = ?,
                            date_of_birth = ?
                            WHERE UserID = ?";
            $update_stmt = mysqli_prepare($dbconnect, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'ssssssi', $first_name, $last_name, $middle_name, $email, $phone_number, $date_of_birth, $userID);

            if (mysqli_stmt_execute($update_stmt)) {
                echo "User details updated successfully.";
        
                // Redirect back to profile.php
                header("Location: profile.php");
                exit(); // Ensure that no further code is executed after the redirect
            } else {
                echo "Error updating user details: " . mysqli_error($dbconnect);
            }

            // Close the prepared statement
            mysqli_stmt_close($update_stmt);
        }
    } else {
        echo "User query failed: " . mysqli_error($dbconnect);
    }



    // Close database connection
    mysqli_close($dbconnect);
?>


