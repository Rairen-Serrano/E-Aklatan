<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="../css/style.css">

    <!--Javascript link here-->
    <script defer src="../js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" charset="UTF-8"></script>
    <script src="../js/jquery-3.7.1.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>Book Pages</title>
</head>
<body id="BooksPage">
    <!--one line code for navbar-->
    <div id="navbar-placeholder"></div>

    <!--Book Page Container-->
    <div class="booksPage_container">

        <!-- include the dbconnect.php for call the database -->
        <?php
            include("dbconnect.php");

            $book_sql="SELECT * FROM books";
            $book_query=mysqli_query($dbconnect, $book_sql);

            // Check if the query was successful
            if (!$book_query) {
                echo "Error: " . mysqli_error($dbconnect);
                exit;
            }
        ?>

        <!--Side Bar-->
        <div class="sidebar_container">
            <!--Top Categories-->
            <div class="sidebar_categories_wrapper">
                <h3>TOP CATEGORIES</h3>
                <div class="sidebar_categories">
                    <ul>
                        <li><a href="../html/books-categories.php?GenreID=6">Fiction</a></li>
                        <li><a href="../html/books-categories.php?GenreID=1">Science Fiction</a></li>
                        <li><a href="../html/books-categories.php?GenreID=5">Mystery</a></li>
                        <li><a href="../html/books-categories.php?GenreID=4">History</a></li>
                        <li><a href="../html/books-categories.php?GenreID=3">Politics</a></li>
                        <li><a href="../html/books-categories.php?GenreID=2">Educational</a></li>
                    </ul>
                </div>
            </div>



            <!--Trending Books-->
            <div class="sidebar_wrapper">
                <h3>TRENDING BOOKS</h3>
                    <?php
                        $Trendingbooks_sql="SELECT BookID, FrontCover, BookTitle, Ratings FROM books WHERE Ratings='★★★★★' ORDER BY BookID LIMIT 5";
                        $Trendingbooks_query=mysqli_query($dbconnect, $Trendingbooks_sql);
                        $Trendingbooks_set=mysqli_fetch_assoc($Trendingbooks_query);


                    do{ ?>
                        <div class="trendBook_wrapper">
                            <div class="book_box">
                                <a href="../html/book_info.php?BookID=<?php echo $Trendingbooks_set['BookID']?>">
                                <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($Trendingbooks_set['FrontCover']).'"/>';?> </a>
                            </div>
                            <div class="sidebar_book_info">
                                <h3> <?php echo $Trendingbooks_set['BookTitle'] ?> </h3>
                                <h5> <?php echo $Trendingbooks_set['Ratings']; ?> </h5>
                                
                            </div>
                        </div>
                    <?php
                        }while($Trendingbooks_set=mysqli_fetch_assoc($Trendingbooks_query));
                    ?>
            </div>
        </div>


        <!-- Main Content -->
        <div class="books_container">
            <div class="books_header">
                <a href="../html/books.php" style="text-decoration: none; color: black;"><h2>Books</h2></a>
                <div class="search-container">
                    <input class="searchbar" id="live_search" type="search" placeholder="Search.." name="search">
                </div>
            </div>

            <div id="searchresult"></div>


            <div class="book-wrapper" id="book-wrapper">
                <?php
                $itemCount = 0;
                $itemsPerRow = 4;

                // Loop through the results
                while ($book_set = mysqli_fetch_assoc($book_query)) {
                    // Check if it's the first item in the row
                    if ($itemCount % $itemsPerRow === 0) {
                        // Close the previous row if it's not the first row
                        if ($itemCount > 0) {
                            echo '</div>';
                        }
                        echo '<div class="books_wrapper">';
                    }

                    // Display book information
                    ?>
                    <a href="../html/book_info.php?BookID=<?php echo $book_set['BookID'] ?>" style="text-decoration: none; color: black;">
                        <div class="book">
                            <div class="book_img">
                                <?php
                                echo '<img src="data:image;base64,' . base64_encode($book_set['FrontCover']) . '">';
                                ?>
                            </div>
                            <div class="cover_container">
                                <img src="../images/borrowBookButton.png">
                            </div>
                            <div class="book_info">
                                <h2><?php echo $book_set['BookTitle']; ?></h2>
                                <h3><?php echo $book_set['Ratings']; ?></h3>
                            </div>
                        </div>
                    </a>
                    <?php

                    // Increment the item count
                    $itemCount++;
                }

                // Close the last row if there are remaining items
                if ($itemCount > 0) {
                    echo '</div>';
                }
                ?>
            </div>




            <!--Pagination -->
            <div class="pagination" id="hide_pagination">
                <li class="page-item previous-page disable"><a class="page-link" href="#">Prev</a></li>
                <li class="page-item current-page active"><a class="page-link" href="#">1</a></li>
                <li class="page-item dots"><a class="page-link" href="#">...</a></li>
                <li class="page-item current-page"><a class="page-link" href="#">5</a></li>
                <li class="page-item current-page"><a class="page-link" href="#">6</a></li>
                <li class="page-item dots"><a class="page-link" href="#">...</a></li>
                <li class="page-item current-page"><a class="page-link" href="#">10</a></li>
                <li class="page-item next-page"><a class="page-link" href="#">Next</a></li>
            </div>
        </div>
    </div>




    <!--one line code for footer-->
    <div id="footer-placeholder"></div>
</body>
</html>