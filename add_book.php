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
<body>
    <!--one line code for navbar-->
    <div id="admin-navbar-placeholder"></div>



    <?php
        // Include your database connection file
        include("dbconnect.php");

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Collect user input
            $bookTitle = $_POST["bookTitle"];
            $author = $_POST["author"];
            $genre = $_POST["genre"];
            $publishedDate = $_POST["publishedDate"];
            $ratings = $_POST["ratings"];
            $abstract = $_POST["abstract"];

            // Front cover file handling
            if (isset($_FILES["frontCover"]) && $_FILES["frontCover"]["error"] == 0) {
                $frontCoverPath = $_FILES["frontCover"]["tmp_name"];
                $frontCover = file_get_contents($frontCoverPath);
            }

            // SQL query to insert data into the books table
            $sql = "INSERT INTO books (BookTitle, FrontCover, Author, Genre, PublishedDate, Ratings, Abstract)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            // Prepare the SQL statement
            $stmt = mysqli_prepare($dbconnect, $sql);

            // Bind parameters to the statement using "b" for binary data
            mysqli_stmt_bind_param($stmt, "ssssdss", $bookTitle, $frontCover, $author, $genre, $publishedDate, $ratings, $abstract);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            // Close the statement and database connection
            mysqli_stmt_close($stmt);
            mysqli_close($dbconnect);
        }
    ?>



  <h2 class="newbook_header">Add a New Book</h2>
    <form method="post" enctype="multipart/form-data" class="newbook_form">
        <label for="bookTitle">Book Title:</label>
        <input type="text" name="bookTitle" required><br>

        <label for="author">Author:</label>
        <input type="text" name="author" required><br>

        <label for="genre">Genre:</label>
        <input type="text" name="genre" required><br>

        <label for="publishedDate">Published Year:</label>
        <input type="text" name="publishedDate" required><br>

        <label for="ratings">Ratings:</label>
        <input type="text" step="0.1" name="ratings" required><br>

        <label for="abstract">Abstract:</label>
        <textarea name="abstract" rows="4" required></textarea><br>

        <label for="frontCover">Front Cover:</label>
        <input type="file" name="frontCover" accept="image/*" required><br>

        <button type="submit">Add Book</button>
    </form>

















  
</body>
</html>