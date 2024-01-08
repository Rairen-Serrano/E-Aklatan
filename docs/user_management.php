<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="../css/style.css">

    <!--Javascript link here-->
    <script defer src="../js/script.js" ></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/jquery-3.7.1.js" defer></script>
    <script src="https://kit.fontawesome.com/af562a2a63.js"></script>

    <title>User Management Page</title>

</head>
<body>
  <!--one line code for navbar-->
  <div id="admin-navbar-placeholder"></div>

  <h2 class="newbook_header">Users Management</h2>

  <?php
include("dbconnect.php");

// Check if the delete button is clicked
if (isset($_POST['delete_user'])) {
    $deleteUserID = $_POST['delete_user'];

    // Check if the confirmation checkbox is checked
    if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'on') {
        try {
            // Start a transaction
            mysqli_begin_transaction($dbconnect);

            // Delete from users table
            $deleteUserSQL = "DELETE FROM users WHERE UserID = ?";
            $stmt = mysqli_prepare($dbconnect, $deleteUserSQL);
            mysqli_stmt_bind_param($stmt, "i", $deleteUserID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Delete from borrowers_form table
            $deleteBorrowerSQL = "DELETE FROM borrowers_form WHERE UserID = ?";
            $stmtBorrower = mysqli_prepare($dbconnect, $deleteBorrowerSQL);
            mysqli_stmt_bind_param($stmtBorrower, "i", $deleteUserID);
            mysqli_stmt_execute($stmtBorrower);
            mysqli_stmt_close($stmtBorrower);

            // Delete from account_details table
            $deleteAccountSQL = "DELETE FROM account_details WHERE UserID = ?";
            $stmtAccount = mysqli_prepare($dbconnect, $deleteAccountSQL);
            mysqli_stmt_bind_param($stmtAccount, "i", $deleteUserID);
            mysqli_stmt_execute($stmtAccount);
            mysqli_stmt_close($stmtAccount);

            // Commit the transaction
            mysqli_commit($dbconnect);

            // Perform any additional cleanup or redirection after deletion
            header("Location: user_management.php");
            exit();
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            mysqli_rollback($dbconnect);
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Please confirm the deletion by checking the checkbox.";
    }
}

// Fetch user data
if (isset($_GET['userID'])) {
    $selectedUserID = $_GET['userID'];

    $sql = "SELECT u.UserID, u.email AS userEmail, ad.first_name, ad.last_name, ad.middle_name, ad.phone_number, ad.date_of_birth
            FROM users u
            JOIN account_details ad ON u.UserID = ad.UserID
            WHERE u.UserID = $selectedUserID";

    $result = mysqli_query($dbconnect, $sql);

    if ($result) {
        ?>
        <form method='post'>
            <div class="dashboard_container">
                <table class="dashboard_table">
                    <thead>
                        <tr>
                            <th>UserID</th>
                            <th>UserEmail</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Phone Number</th>
                            <th>Date of Birth</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><a class="userid_link" href='borrowedbooks_management.php?userID=<?php echo $row['UserID']; ?>'><?php echo $row['UserID']; ?></a></td>
                                <td><?php echo $row['userEmail']; ?></td>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php echo $row['middle_name']; ?></td>
                                <td><?php echo $row['phone_number']; ?></td>
                                <td><?php echo $row['date_of_birth']; ?></td>
                                <td>
                                    <input type='checkbox' name='confirm_delete' value='on'> Confirm
                                    <button type='submit' name='delete_user' value='<?php echo $row['UserID']; ?>'>Delete</button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
        <?php
    } else {
        echo "Error: " . mysqli_error($dbconnect);
    }
} else {
    // Display all users when no specific UserID is specified
    $sqlAllUsers = "SELECT u.UserID, u.email AS userEmail, ad.first_name, ad.last_name, ad.middle_name, ad.phone_number, ad.date_of_birth
                    FROM users u
                    JOIN account_details ad ON u.UserID = ad.UserID";

    $resultAllUsers = mysqli_query($dbconnect, $sqlAllUsers);

    if ($resultAllUsers) {
        ?>
        <form method='post'>
            <div class="dashboard_container">
                <table class="dashboard_table">
                    <thead>
                        <tr>
                            <th>UserID</th>
                            <th>UserEmail</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Phone Number</th>
                            <th>Date of Birth</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowAllUsers = mysqli_fetch_assoc($resultAllUsers)) {
                            ?>
                            <tr>
                                <td><a class="userid_link" href='borrowedbooks_management.php?userID=<?php echo $rowAllUsers['UserID']; ?>'><?php echo $rowAllUsers['UserID']; ?></a></td>
                                <td><?php echo $rowAllUsers['userEmail']; ?></td>
                                <td><?php echo $rowAllUsers['first_name']; ?></td>
                                <td><?php echo $rowAllUsers['last_name']; ?></td>
                                <td><?php echo $rowAllUsers['middle_name']; ?></td>
                                <td><?php echo $rowAllUsers['phone_number']; ?></td>
                                <td><?php echo $rowAllUsers['date_of_birth']; ?></td>
                                <td>
                                    <input type='checkbox' name='confirm_delete' value='on'> Confirm
                                    <button type='submit' name='delete_user' value='<?php echo $rowAllUsers['UserID']; ?>'>Delete</button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
        <?php
    } else {
        echo "Error: " . mysqli_error($dbconnect);
    }
}

mysqli_close($dbconnect);
?>




    
</body>
</html>