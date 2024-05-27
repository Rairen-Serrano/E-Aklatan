<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="css/style.css">

    <!--Javascript link here-->
    <script defer src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" charset="UTF-8"></script>
    <script src="js/jquery-3.7.1.js" defer></script>

    <title>Books Categories Page</title>

</head>
<body>
    <!--one line code for navbar-->
    <div id="navbar-placeholder"></div>


    <!-- include the dbconnect.php for call the database -->
    <?php
        include("dbconnect.php");

        $booksCat_sql = "SELECT BookID, FrontCover, BookTitle, Ratings, GenreID FROM books WHERE GenreID=" . $_GET['GenreID'];

        $booksCat_query = mysqli_query($dbconnect, $booksCat_sql);
        
        // Check if the query was successful
        if (!$booksCat_query) {
            echo "Error: " . mysqli_error($dbconnect);
            exit;
        }
        
        ?>


    <div class="booksPage_container">

        <!--Side Bar-->
        <div class="sidebar_container">
            <!--Top Categories-->
            <div class="sidebar_categories_wrapper">
                <h3>TOP CATEGORIES</h3>
                <div class="sidebar_categories">
                    <ul>
                        <li><a href="books-categories.php?GenreID=6">Fiction</a></li>
                        <li><a href="books-categories.php?GenreID=1">Science Fiction</a></li>
                        <li><a href="books-categories.php?GenreID=5">Mystery</a></li>
                        <li><a href="books-categories.php?GenreID=4">History</a></li>
                        <li><a href="books-categories.php?GenreID=3">Politics</a></li>
                        <li><a href="books-categories.php?GenreID=2">Educational</a></li>
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
                                <a href="book_info.php?BookID=<?php echo $Trendingbooks_set['BookID']?>">
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
                <a href="books.php" style="text-decoration: none; color: black;"><h2>Books</h2></a>
                <div class="search-container">
                    <input class="searchbar" type="search" placeholder="Search.." name="search">
                    <button class="searchbar_btn" type="submit"><p>Search</p></button>
                </div>
            </div>


            <div class="book-wrapper">
                <?php
                $itemCount = 0;
                $itemsPerRow = 4;

                // Loop through the results
                while ($booksCat_set = mysqli_fetch_assoc($booksCat_query)) {
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
                    <a href="book_info.php?BookID=<?php echo $booksCat_set['BookID'] ?>" style="text-decoration: none; color: black;">
                        <div class="book">
                            <div class="book_img">
                                <?php
                                echo '<img src="data:image;base64,' . base64_encode($booksCat_set['FrontCover']) . '">';
                                ?>
                            </div>
                            <div class="cover_container">
                                <img src="/images/borrowBookButton.png">
                            </div>
                            <div class="book_info">
                                <h2><?php echo $booksCat_set['BookTitle']; ?></h2>
                                <h3><?php echo $booksCat_set['Ratings']; ?></h3>
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
        </div>
    </div>







    <!--one line code for footer-->
    <div id="footer-placeholder"></div>    
</body>
</html>