<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="css/style.css">

    <!--Javascript link here-->
    <script defer src="js/script.js" ></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="js/jquery-3.7.1.js" defer></script>
    <script src="https://kit.fontawesome.com/af562a2a63.js"></script>

    <title>User logs Page</title>

</head>
<body>
  <!--one line code for navbar-->
  <div id="admin-navbar-placeholder"></div>

  <h2 class="newbook_header">User Logs</h2>

  <?php
include("dbconnect.php");

// Fetch user data
if (isset($_GET['userID'])) {
    $selectedUserID = $_GET['userID'];

    $sql = "SELECT u.UserID, u.email AS userEmail, ad.first_name, ad.last_name, ad.middle_name, ad.phone_number, ad.date_of_birth, u.time_log_in, u.time_log_out
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
                            <th>Time Log in </th>
                            <th>Time log out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><a class="userid_link" href='user_management.php?userID=<?php echo $row['UserID']; ?>'><?php echo $row['UserID']; ?></a></td>
                                <td><?php echo $row['userEmail']; ?></td>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php echo $row['middle_name']; ?></td>
                                <td><?php echo $row['phone_number']; ?></td>
                                <td><?php echo $row['date_of_birth']; ?></td>
                                <td><?php echo $row['time_log_in']; ?></td>
                                <td><?php echo $row['time_log_out']; ?></td>
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
    $sqlAllUsers = "SELECT u.UserID, u.email AS userEmail, ad.first_name, ad.last_name, ad.middle_name, ad.phone_number, ad.date_of_birth, u.time_log_in, u.time_log_out
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
                            <th>Time Log in </th>
                            <th>Time Log out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowAllUsers = mysqli_fetch_assoc($resultAllUsers)) {
                            ?>
                            <tr>
                                <td><a class="userid_link" href='user_management.php?userID=<?php echo $rowAllUsers['UserID']; ?>'><?php echo $rowAllUsers['UserID']; ?></a></td>
                                <td><?php echo $rowAllUsers['userEmail']; ?></td>
                                <td><?php echo $rowAllUsers['first_name']; ?></td>
                                <td><?php echo $rowAllUsers['last_name']; ?></td>
                                <td><?php echo $rowAllUsers['middle_name']; ?></td>
                                <td><?php echo $rowAllUsers['phone_number']; ?></td>
                                <td><?php echo $rowAllUsers['date_of_birth']; ?></td>
                                <td><?php echo !empty($rowAllUsers['time_log_in']) ? date('D, M j, Y g:i:s A', strtotime($rowAllUsers['time_log_in'])) : ''; ?></td>
                                <td><?php echo !empty($rowAllUsers['time_log_out']) ? date('D, M j, Y g:i:s A', strtotime($rowAllUsers['time_log_out'])) : ''; ?></td>
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