<!--CSS link here-->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

    // Query to retrieve user details from the account_details table
    $account_query = "SELECT * FROM account_details WHERE UserID = ?";
    $account_stmt = mysqli_prepare($dbconnect, $account_query);
    mysqli_stmt_bind_param($account_stmt, 'i', $userID);
    mysqli_stmt_execute($account_stmt);
    $account_result = mysqli_stmt_get_result($account_stmt);

    if ($account_result && $account_row = mysqli_fetch_assoc($account_result)) {
        // Access account details
        $first_name = $account_row['first_name'];
        $last_name = $account_row['last_name'];
        $middle_name = $account_row['middle_name'];
        $email = $account_row['email'];
        $phone_number = $account_row['phone_number'];
        $date_of_birth = $account_row['date_of_birth'];
    } else {
        echo "No account details found for the user.";
    }
} else {
    echo "User query failed: " . mysqli_error($dbconnect);
}

// Close database connection
mysqli_close($dbconnect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Account Details</title>
</head>
<body>

<div class="accountdetails-box">
    <h1>Account Details</h1>
    <form action="update_account.php" method="post" class="accountdetails_container">
        <div class="form_accountdetails">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
        </div>

        <div class="form_accountdetails">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>">
        </div>

        <div class="form_accountdetails">
            <label for="middle_name">Middle Name:</label>
            <input type="text" id="middle_name" name="middle_name" value="<?php echo $middle_name; ?>">
        </div>

        <div class="form_accountdetails">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $user_email; ?>" readonly>
        </div>

        <div class="form_accountdetails">
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>">
        </div>

        <div class="form_accountdetails">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="text" id="date_of_birth" name="date_of_birth" value="<?php echo $date_of_birth; ?>">
        </div>


        <input type="submit" value="Save Changes">
    </form>
</div>

</body>
</html>










