


<?php 
    session_start();
    include 'dbconnect.php';

    // Check if the borrow-submit button is clicked
    //if(isset($_POST["borrow-button"])) {
        // Check if the user is logged in
        if(!isset($_SESSION['SESSION_EMAIL'])) {
            header("Location: login.php");
            die();
        }

        // Use prepared statements to prevent SQL injection
        $users_query = mysqli_query($dbconnect, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

            if (mysqli_num_rows($users_query) > 0) {
                $users_row = mysqli_fetch_assoc($users_query);
        
                $borrowers_userid = $users_row['UserID'];
            }
    //} 
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="../css/style.css">

    <!--Javascript link here-->
    <script defer src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" charset="UTF-8"></script>
    <script src="js/jquery-3.7.1.js" defer></script>

    <title>Book Info Page</title>

</head>
<body id="book_info">
    <!--one line code for navbar-->
    <div id="navbar-placeholder"></div>

    <div class="bookpage_container">
        <div class="GoBack">
            <a href="books.php"><img src="images/angle-left-solid.svg" alt="LeftButton"></a>
            <a href="books.php"><h4>&nbsp;&nbsp;&nbsp;GO BACK</h4></a>
        </div>


        <?php 
            include("dbconnect.php");
            $bookinfo_sql="SELECT * FROM books WHERE BookID=".$_GET['BookID'];

            if($bookinfo_query=mysqli_query($dbconnect, $bookinfo_sql)) {
                $bookinfo_set=mysqli_fetch_assoc($bookinfo_query);
                ?>


                <!--Book Info-->
                <div class="bookinfo_container">
                    <div class="bookFrontCover">
                        <?php
                            echo '<img src="data:image/jpeg;base64,'.base64_encode($bookinfo_set['FrontCover']).'"/>';
                        ?>  
                    </div>
                    
                    <div class="bookinfo-1">
                        <h2> <?php echo $bookinfo_set['BookTitle'] ?> </h2>
                        <h5><strong>Published Date:</strong> <?php echo $bookinfo_set ['PublishedDate'] ?> </h5>
                        <h5><strong>Author:</strong> <?php echo $bookinfo_set ['Author'] ?> </h5>
                        <h5><strong>Genre:</strong> <?php echo $bookinfo_set ['Genre'] ?> </h5>
                        <h5><strong>Ratings:</strong> <?php echo $bookinfo_set ['Ratings'] ?> </h5>
                        <p><strong>Abstract:</strong> <?php echo $bookinfo_set ['Abstract'] ?> </p>
                        <button id="borrow-btn" name="borrow-button" class="borrow-button">BORROW</button>

                        <div class="popup">
                            <div class="close-btn">&times;</div>
                            <h2>Borrower's Form</h2>
                            <div class="popup-form">
                                <form action="" method="post" autocomplete="off" class="" enctype="multipart/form-data" id="borrow-form">
                                    <div class="form-element">
                                        <label for="full_name">Full Name: </label><br>
                                        <input type="text" name="full_name" placeholder="Enter Your Full Name" required value="">
                                    </div>
                                    <div class="form-element">
                                        <label for="house_number">House no. & Street: </label><br>
                                        <input type="text" name="house_number" placeholder="Enter Your House no. & Street" required value="">
                                    </div>
                                    <div class="form-element">
                                        <label for="baranggay">Baranggay: </label><br>
                                        <input type="text" name="baranggay" placeholder="Enter Your Baranggay" required value="">
                                    </div>
                                    <div class="form-element">
                                        <label for="city">City: </label><br>
                                        <input type="text" name="city" placeholder="Enter Your City" required>
                                    </div>
                                    <div class="form-element">
                                        <label for="contact_number">Contact Number: </label><br>
                                        <input type="text" name="contact_number" placeholder="Enter Your Contact Number" required value="">
                                    </div>
                                    <div class="form-element">
                                        <label for="days_borrowed">Days to be Borrowed: </label><br>
                                        <select name="days_borrowed" id="days_borrowed">
                                            <option value="3">3 Days</option>
                                            <option value="5">5 Days</option>
                                            <option value="7">7 Days</option>
                                        </select>
                                    </div>
                                    <?php if(!empty($statusMsg)){ ?>
                                        <p class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></p>
                                    <?php } ?>
                                    <div class="form-element">
                                        <label for="borrowers_id">Upload any valid ID or school ID: </label><br>
                                        <input type="file" name="borrowers_id" id="borrowers_id" value="" required>
                                    </div>
                                    <div class="form-element">
                                        <button type="submit" class="borrow-submit" id="submit-btn" name="borrow-submit">SUBMIT</button>
                                    </div>
                                </form>

                                
                                <?php // Inserting data that the user inputted in the Borrower's Form
                                    include ("dbconnect.php");

                                    // Process form submission
                                    if (isset($_POST["borrow-submit"])) {
                                        // Get form data
                                        $full_name = $_POST["full_name"];
                                        $house_number = $_POST["house_number"];
                                        $baranggay = $_POST["baranggay"];
                                        $city = $_POST["city"];
                                        $contact = $_POST["contact_number"];
                                        $days_borrowed = $_POST["days_borrowed"];
                                        

                                        // Getting BookID from book table
                                        if (isset($_GET['BookID'])) {
                                            // Retrieve BookID from the books table
                                            $bookinfo_sql = "SELECT * FROM books WHERE BookID=" . $_GET['BookID'];
                                            $borrowers_bookid_result = $dbconnect->query($bookinfo_sql);

                                            if ($borrowers_bookid_result && $borrowers_bookid_result->num_rows > 0) {
                                                // Fetch the result row
                                                $row = $borrowers_bookid_result->fetch_assoc();

                                                $borrowers_bookid = $row['BookID'];
                                            }
                                        }

                                        // Uploading borrowers id
                                        $statusMsg = "";
                                        $status = 'danger';

                                        // File upload directory
                                        $targetDir = '../uploads/';

                                        if(!empty($_FILES["borrowers_id"]["name"])){
                                            $fileName = basename($_FILES["borrowers_id"]["name"]);
                                            $targetFilePath = $targetDir . $fileName;
                                            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

                                            // Allow certain file formats
                                            $allowTypes = array('jpg','png','jpeg','gif');
                                            if(in_array($fileType, $allowTypes)){
                                                // Upload file
                                                if(move_uploaded_file($_FILES["borrowers_id"]["tmp_name"], $targetFilePath)){
                                                    $status = 'success';
                                                    $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                                                } else {
                                                    $statusMsg = "Sorry, there was an error uploading the file";
                                                }
                                            } else {
                                                $statusMsg = "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
                                            }
                                        } else {
                                            $statusMsg = "Please select a file to upload.";
                                        }

                                        // Insert data into the database
                                        $borrowers_sql = "INSERT INTO borrowers_form VALUES ('', '$borrowers_bookid', '$borrowers_userid','$full_name', '$house_number', '$baranggay', '$city', '$contact', '$days_borrowed', '".$fileName."', NOW(), DATE_ADD(NOW(), INTERVAL $days_borrowed DAY))";
                                        $borrowers_result = mysqli_query($dbconnect, $borrowers_sql);
                                        
                                        if ($borrowers_result) {
                                            echo "<script> alert('Success.'); </script>";
                                            
                                        }   
                                    } 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>    
                <?php
            }
        ?>
    </div>

    <!--one line code for footer-->
    <div id="footer-placeholder"></div>    
</body>
</html>