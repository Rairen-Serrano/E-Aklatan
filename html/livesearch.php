<?php 

    include("dbconnect.php");

    if(isset($_POST['input'])){
        $input = $_POST['input'];
        
        $livesearch_query = "SELECT * FROM books WHERE BookTitle LIKE '{$input}%' OR Author LIKE '{$input}%' 
        OR PublishedDate LIKE '{$input}%' OR Genre LIKE '{$input}%' ";

        $livesearch_result = mysqli_query($dbconnect, $livesearch_query);

        if(mysqli_num_rows($livesearch_result) > 0){

        ?>



            <div class="book-wrapper">
                <?php
                $itemCount = 0;
                $itemsPerRow = 4;

                // Loop through the results
                while ($livesearch_row = mysqli_fetch_assoc($livesearch_result)) {
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
                    <a href="../html/book_info.php?BookID=<?php echo $livesearch_row['BookID'] ?>" style="text-decoration: none; color: black;">
                        <div class="book">
                            <div class="book_img">
                                <?php
                                echo '<img src="data:image;base64,' . base64_encode($livesearch_row['FrontCover']) . '">';
                                ?>
                            </div>
                            <div class="cover_container">
                                <img src="../images/borrowBookButton.png">
                            </div>
                            <div class="book_info">
                                <h2><?php echo $livesearch_row['BookTitle']; ?></h2>
                                <h3><?php echo $livesearch_row['Ratings']; ?></h3>
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



        <?php

        }else{
            echo "<h3 class='text-danger text-center mt-3'>No Book Found</h3>";
        }





    }

?>