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

  <h2 class="newbook_header">Borrowed Books Management</h2>

  <?php
include("dbconnect.php");

// Check if the delete button is clicked
if (isset($_POST['delete_data'])) {
    $deleteBookID = $_POST['delete_data'];

    // Check if the Returned checkbox is checked
    if (isset($_POST['returned']) && in_array($deleteBookID, $_POST['returned'])) {
        // Perform the deletion in the database (adjust the table name accordingly)
        $deleteDataSQL = "DELETE FROM borrowers_form WHERE BookID = ?";
        $stmt = mysqli_prepare($dbconnect, $deleteDataSQL);
        mysqli_stmt_bind_param($stmt, "i", $deleteBookID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Perform any additional cleanup or redirection after deletion
        header("Location: borrowedbooks_management.php");
        exit();
    } else {
        echo "Please check the Returned checkbox to delete the data.";
    }
}

// Fetch data
if (isset($_GET['bookID'])) {
    $selectedBookID = $_GET['bookID'];

    $sql = "SELECT bf.UserID, bf.BookID, b.BookTitle, bf.date_borrowed, bf.return_date
            FROM borrowers_form bf
            JOIN users u ON bf.UserID = u.UserID
            JOIN books b ON bf.BookID = b.BookID
            WHERE bf.BookID = $selectedBookID
            ORDER BY bf.UserID";

    $result = mysqli_query($dbconnect, $sql);

    if ($result) {
        ?>
        <form method='post'>
            <div class="dashboard_container">
                <table class="dashboard_table">
                    <thead>
                        <tr>
                            <th>UserID</th>
                            <th>BookID</th>
                            <th>BookTitle</th>
                            <th>date_borrowed</th>
                            <th>return_date</th>
                            <th>Returned</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><a class="userid_link" href='user_management.php?userID=<?php echo $row['UserID']; ?>'><?php echo $row['UserID']; ?></a></td>
                                <td><a href='book_management.php?bookID=<?php echo $row['BookID']; ?>'><?php echo $row['BookID']; ?></a></td>
                                <td><?php echo $row['BookTitle']; ?></td>
                                <td><?php echo $row['date_borrowed']; ?></td>
                                <td><?php echo $row['return_date']; ?></td>
                                <td><input type='checkbox' name='returned[]' value='<?php echo $row['BookID']; ?>'></td>
                                <td><button type='submit' name='delete_data' value='<?php echo $row['BookID']; ?>'>Delete Data</button></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <input type="submit" value="Delete Selected">
            </div>
        </form>
        <?php
    } else {
        echo "Error: " . mysqli_error($dbconnect);
    }
} else {
    // Fetch all data when no specific BookID is specified
    $sqlAllData = "SELECT bf.UserID, bf.BookID, b.BookTitle, bf.date_borrowed, bf.return_date
                    FROM borrowers_form bf
                    JOIN users u ON bf.UserID = u.UserID
                    JOIN books b ON bf.BookID = b.BookID
                    ORDER BY bf.UserID";

    $resultAllData = mysqli_query($dbconnect, $sqlAllData);

    if ($resultAllData) {
        ?>
        <form method='post'>
            <div class="dashboard_container">
                <table class="dashboard_table">
                    <thead>
                        <tr>
                            <th>UserID</th>
                            <th>BookID</th>
                            <th>BookTitle</th>
                            <th>date_borrowed</th>
                            <th>return_date</th>
                            <th>Returned</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowAllData = mysqli_fetch_assoc($resultAllData)) {
                            ?>
                            <tr>
                                <td><a style="text-decoration: none; color: #0097B2" href='user_management.php?userID=<?php echo $rowAllData['UserID']; ?>'><?php echo $rowAllData['UserID']; ?></a></td>
                                <td><a class="userid_link" href='book_management.php?bookID=<?php echo $rowAllData['BookID']; ?>'><?php echo $rowAllData['BookID']; ?></a></td>
                                <td><?php echo $rowAllData['BookTitle']; ?></td>
                                <td><?php echo $rowAllData['date_borrowed']; ?></td>
                                <td><?php echo $rowAllData['return_date']; ?></td>
                                <td><input type='checkbox' name='returned[]' value='<?php echo $rowAllData['BookID']; ?>'></td>
                                <td><button type='submit' name='delete_data' value='<?php echo $rowAllData['BookID']; ?>'>Delete Data</button></td>
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