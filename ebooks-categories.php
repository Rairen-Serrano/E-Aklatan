<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="css/style.css">

    <!--Javascript link here -->
    <script src="js/script.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <title>EBooks Categories Page</title>

</head>
<body>
    <!--one line code for navbar-->
    <div id="navbar-placeholder"> </div>



    <!-- include the dbconnect.php for call the database -->
    <?php
        include("dbconnect.php");

        $ebooksCat_sql = "SELECT ebook_id, front_cover, ebook_title, ratings, genre_id FROM ebooks WHERE genre_id=" . $_GET['genre_id'];

        $ebooksCat_query = mysqli_query($dbconnect, $ebooksCat_sql);
        
        // Check if the query was successful
        if (!$ebooksCat_query) {
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
                        <li><a href="ebooks-categories.php?genre_id=1">Thriller</a></li>
                        <li><a href="ebooks-categories.php?genre_id=5">Finance</a></li>
                        <li><a href="ebooks-categories.php?genre_id=4">General</a></li>
                        <li><a href="ebooks-categories.php?genre_id=3">Computer</a></li>
                        <li><a href="ebooks-categories.php?genre_id=2">Fiction and Literature</a></li>
                    </ul>
                </div>
            </div>



            <!--Trending Books-->
            <div class="sidebar_wrapper">
                <h3>TRENDING BOOKS</h3>
                    <?php
                        $Trendingebooks_sql="SELECT ebook_id, front_cover, ebook_title, ratings FROM ebooks WHERE ratings='★★★★★' ORDER BY ebook_id LIMIT 5";
                        $Trendingebooks_query=mysqli_query($dbconnect, $Trendingebooks_sql);
                        $Trendingebooks_set=mysqli_fetch_assoc($Trendingebooks_query);


                    do{ ?>
                        <div class="trendBook_wrapper">
                            <div class="book_box">
                                <a href="ebook_info.php?book_id=<?php echo $Trendingebooks_set['ebook_id']?>">
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
                <a href="../html/ebooks.php" style="text-decoration: none; color: black;"><h2>E-Books</h2></a>
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
                while ($ebooksCat_set = mysqli_fetch_assoc($ebooksCat_query)) {
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
                    <a href="../html/ebook_info.php?ebook_id=<?php echo $ebooksCat_set['ebook_id'] ?>" style="text-decoration: none; color: black;">
                        <div class="book">
                            <div class="book_img">
                                <?php
                                echo '<img src="data:image;base64,' . base64_encode($ebooksCat_set['front_cover']) . '">';
                                ?>
                            </div>
                            <div class="cover_container">
                                <img src="../images/donwload_button.svg">
                            </div>
                            <div class="book_info">
                                <h2><?php echo $ebooksCat_set['ebook_title']; ?></h2>
                                <h3><?php echo $ebooksCat_set['ratings']; ?></h3>
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