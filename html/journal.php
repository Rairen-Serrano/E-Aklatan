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

    <title>Journal Page</title>

</head>
<body>
    <!--one line code for navbar-->
    <div id="navbar-placeholder"></div>
    






    <!--Book Page Container-->
    <div class="booksPage_container">

        <!-- include the dbconnect.php for call the database -->
        <?php
            include("dbconnect.php");

            $journal_sql="SELECT * FROM journals";
            $journal_query=mysqli_query($dbconnect, $journal_sql);

            // Check if the query was successful
            if (!$journal_query) {
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
                <a href="../html/journal.php" style="text-decoration: none; color: black;"><h2>Journals</h2></a>
            </div>

            <div id="searchresult"></div>


            <div class="book-wrapper" id="book-wrapper">
                <?php
                $itemCount = 0;
                $itemsPerRow = 4;

                // Loop through the results
                while ($journal_set = mysqli_fetch_assoc($journal_query)) {
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
                    <a href="../html/journal_info.php?journal_id=<?php echo $journal_set['journal_id'] ?>" style="text-decoration: none; color: black;">
                        <div class="book">
                            <div class="book_img">
                                <?php
                                echo '<img src="data:image;base64,' . base64_encode($journal_set['front_cover']) . '">';
                                ?>
                            </div>
                            <div class="cover_container">
                                <img src="../images/donwload_button.svg">
                            </div>
                            <div class="book_info">
                                <h2><?php echo $journal_set['journal_title']; ?></h2>
                                <h3>Publisher: <?php echo $journal_set['publisher']; ?></h3>
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