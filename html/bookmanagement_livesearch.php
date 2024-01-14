<?php 

    include("dbconnect.php");

    if(isset($_POST['input'])){
        $input = $_POST['input'];

        
        $livesearch_query = "SELECT * FROM books WHERE BookID LIKE '{$input}%' OR BookTitle LIKE '{$input}%' OR Author LIKE '{$input}%' 
        OR PublishedDate LIKE '{$input}%' OR Genre LIKE '{$input}%' ";

        $livesearch_result = mysqli_query($dbconnect, $livesearch_query);

        if(mysqli_num_rows($livesearch_result) > 0){

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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($livesearch_row = mysqli_fetch_assoc($livesearch_result)) {
                                ?>
                                <tr>
                                    <td><?php echo $livesearch_row['BookID']; ?></td>
                                    <td><?php echo $livesearch_row['BookTitle']; ?></td>
                                    <td><?php echo $livesearch_row['Author']; ?></td>
                                    <td><?php echo $livesearch_row['Genre']; ?></td>
                                    <td><?php echo $livesearch_row['PublishedDate']; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <?php
            } else {
                echo "Error: " . mysqli_error($dbconnect);
            }
        }
            ?>