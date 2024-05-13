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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>Ebooks Page</title>

</head>
<body id="EBooksPage">
     <!--one line code for navbar-->
    <div id="navbar-placeholder"> </div>



    <!--Book Page Container-->
    <div class="booksPage_container">

        <!-- include the dbconnect.php for call the database -->
        <?php
            include("dbconnect.php");

            $ebook_sql="SELECT * FROM ebooks";
            $ebook_query=mysqli_query($dbconnect, $ebook_sql);

            // Check if the query was successful
            if (!$ebook_query) {
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
                        <li><a href="ebooks-categories.php?genre_id=1">Thriller</a></li>
                        <li><a href="ebooks-categories.php?genre_id=5">Finance</a></li>
                        <li><a href="ebooks-categories.php?GenreID=4">General</a></li>
                        <li><a href="ebooks-categories.php?GenreID=3">Computer</a></li>
                        <li><a href="ebooks-categories.php?genre_id=2">Fiction and Literature</a></li>
                    </ul>
                </div>
            </div>



            <!--Trending Books-->
            <div class="sidebar_wrapper">
                <h3>TRENDING BOOKS</h3>
                    <?php
                        $Trendingebooks_sql="SELECT ebook_id, front_cover, ebook_title, ratings FROM ebooks WHERE ratings='★★★★★' OR ratings='★★★★☆' ORDER BY ebook_id LIMIT 5";
                        $Trendingebooks_query=mysqli_query($dbconnect, $Trendingebooks_sql);
                        $Trendingebooks_set=mysqli_fetch_assoc($Trendingebooks_query);


                    do{ ?>
                        <div class="trendBook_wrapper">
                            <div class="book_box">
                                <a href="ebook_info.php?ebook_id=<?php echo $Trendingebooks_set['ebook_id']?>">
                                <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($Trendingebooks_set['front_cover']).'"/>';?> </a>
                            </div>
                            <div class="sidebar_book_info">
                                <h3> <?php echo $Trendingebooks_set['ebook_title'] ?> </h3>
                                <h5> <?php echo $Trendingebooks_set['ratings']; ?> </h5>
                                
                            </div>
                        </div>
                    <?php
                        }while($Trendingebooks_set=mysqli_fetch_assoc($Trendingebooks_query));
                    ?>
            </div>
        </div>


        <!-- Main Content -->
        <div class="books_container">
            <div class="books_header">
                <a href="ebooks.php" style="text-decoration: none; color: black;"><h2>E-Books</h2></a>
                <div class="search-container">
                    <input class="searchbar" id="ebook_live_search" type="search" placeholder="Search.." name="search">
                </div>
            </div>

            <div id="searchresult"></div>


            <div class="book-wrapper" id="book-wrapper">
                <?php
                $itemCount = 0;
                $itemsPerRow = 4;

                // Loop through the results
                while ($ebook_set = mysqli_fetch_assoc($ebook_query)) {
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
                    <a href="ebook_info.php?ebook_id=<?php echo $ebook_set['ebook_id'] ?>" style="text-decoration: none; color: black;">
                        <div class="book">
                            <div class="book_img">
                                <?php
                                echo '<img src="data:image;base64,' . base64_encode($ebook_set['front_cover']) . '">';
                                ?>
                            </div>
                            <div class="cover_container">
                                <img src="images/donwload_button.svg">
                            </div>
                            <div class="book_info">
                                <h2><?php echo $ebook_set['ebook_title']; ?></h2>
                                <h3><?php echo $ebook_set['ratings']; ?></h3>
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