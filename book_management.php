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

    <title>User Management Page</title>

</head>
<body id="book_management">
  <!--one line code for navbar-->
  <div id="admin-navbar-placeholder"></div>


  <h2 class="newbook_header">Books Management</h2>


  <?php
        include("dbconnect.php");

        // Function to handle book deletion
        function deleteBook($bookID, $dbconnect) {
            $deleteSQL = "DELETE FROM books WHERE BookID = ?";
            $stmt = mysqli_prepare($dbconnect, $deleteSQL);
            mysqli_stmt_bind_param($stmt, "i", $bookID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // Check if the delete button is clicked
        if (isset($_POST['delete_button'])) {
            // Check if any books are selected for deletion
            if (isset($_POST['delete_books']) && !empty($_POST['delete_books'])) {
                foreach ($_POST['delete_books'] as $deleteBookID) {
                    deleteBook($deleteBookID, $dbconnect);
                }
                // Redirect or perform additional actions after deletion
                header("Location: book_management.php");
                exit();
            } else {
                echo "Please select books to delete.";
            }
        }

        ?>

        <?php
        // Fetch data
        if (isset($_GET['bookID'])) {
            $selectedBookID = $_GET['bookID'];

            $sql = "SELECT BookID, BookTitle, Author, Genre, PublishedDate 
                    FROM books
                    WHERE BookID = $selectedBookID";

            $result = mysqli_query($dbconnect, $sql);

            if ($result) {
                ?>
                <div class="dashboard_container" id="dashboard_container">
                    <form method="post">
                        <table class="dashboard_table">
                            <thead>
                                <tr>
                                    <th>BookID</th>
                                    <th>BookTitle</th>
                                    <th>Author</th>
                                    <th>Genre</th>
                                    <th>PublishedDate</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['BookID']; ?></td>
                                        <td><?php echo $row['BookTitle']; ?></td>
                                        <td><?php echo $row['Author']; ?></td>
                                        <td><?php echo $row['Genre']; ?></td>
                                        <td><?php echo $row['PublishedDate']; ?></td>
                                        <td>
                                            <input type="checkbox" name="delete_books[]" value="<?php echo $row['BookID']; ?>">
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <button type="submit" name="delete_button">Delete Selected Books</button>
                    </form>
                </div>
                <?php
            } else {
                echo "Error: " . mysqli_error($dbconnect);
            }

            // Check if any rows were fetched
            if (mysqli_num_rows($result) == 0) {
                echo "Book not found.";
            }
        } else { ?>

            <div class="search-container">
                <input class="searchbar" id="bookmanagement_livesearch" type="search" placeholder="Search.." name="search">
            </div>

            <div id="searchresult"></div>

        <?php

            // BookID not provided in the URL, display the list of all books
            $sql = "SELECT BookID, BookTitle, Author, Genre, PublishedDate FROM books";
            $result = mysqli_query($dbconnect, $sql);

            if ($result) {
                ?>
                <div class="dashboard_container">
                    <form method="post">
                        <table class="dashboard_table">
                            <thead>
                                <tr>
                                    <th>BookID</th>
                                    <th>BookTitle</th>
                                    <th>Author</th>
                                    <th>Genre</th>
                                    <th>PublishedDate</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['BookID']; ?></td>
                                        <td><?php echo $row['BookTitle']; ?></td>
                                        <td><?php echo $row['Author']; ?></td>
                                        <td><?php echo $row['Genre']; ?></td>
                                        <td><?php echo $row['PublishedDate']; ?></td>
                                        <td>
                                            <input type="checkbox" name="delete_books[]" value="<?php echo $row['BookID']; ?>">
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <button type="submit" name="delete_button"><a style="text-decoration: none; color: black;" href="../html/add_book.php">Add Book</a></button>
                        <button type="submit" name="delete_button">Delete Selected Books</button>
                    </form>
                </div>
                <?php
            } else {
                echo "Error: " . mysqli_error($dbconnect);
            }
        }

        mysqli_close($dbconnect);
    ?>








    
</body>
</html>