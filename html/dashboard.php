

<!--CSS link here-->
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<?php 
    session_start();
    if(!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: login.php");
        die();
    }

    include 'dbconnect.php';

    ?>
        <div class="dashboardtitle_container">
            <div class="dashboard_title"><p>Dashboard</p></div><br>
            <h4>Books Borrowed</h4>
        </div>
    <?php





// Assuming you have stored the user's email in a session
$user_email = $_SESSION['SESSION_EMAIL'];

// Query to retrieve user information
$user_query = mysqli_query($dbconnect, "SELECT * FROM users WHERE email='$user_email'");

if ($user_query) {
    $user_row = mysqli_fetch_assoc($user_query);

    // Extract the UserID from the user data
    $userID = $user_row['UserID'];

    // Query to retrieve user and book information using JOIN
    $query = "SELECT books.BookID, books.BookTitle,
              books.Author, borrowers_form.date_borrowed, borrowers_form.DaytobeBorrowed,
              DATE_ADD(borrowers_form.date_borrowed, INTERVAL borrowers_form.DaytobeBorrowed DAY) AS return_date
              FROM users
              JOIN borrowers_form ON users.UserID = borrowers_form.UserID
              JOIN books ON borrowers_form.BookID = books.BookID
              WHERE users.email = '$user_email'";

    $users_query = mysqli_query($dbconnect, $query);

    if ($users_query) { ?>
        <div class="dashboard_container">
            <table  class="dashboard_table">
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Date Borrowed</th>
                        <th>Days Borrowed</th>
                        <th>Return Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($users_query)) {
                        // Access user, book, and borrowing data
                        $bookID = $row['BookID'];
                        $bookTitle = $row['BookTitle'];
                        $author = $row['Author'];
                        $dateBorrowed = $row['date_borrowed'];
                        $dayToBeBorrowed = $row['DaytobeBorrowed'];
                        $returnDate = $row['return_date'];
        
                        // Output or process the data as needed
                        ?>
                        <tr>
                            <td><?php echo $bookID; ?></td>
                            <td><?php echo $bookTitle; ?></td>
                            <td><?php echo $author; ?></td>
                            <td><?php echo $dateBorrowed; ?></td>
                            <td><?php echo $dayToBeBorrowed; ?></td>
                            <td><?php echo $returnDate; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } else {
        echo "Query failed: " . mysqli_error($dbconnect);
    }
} else {
    echo "User query failed: " . mysqli_error($dbconnect);
}







?>