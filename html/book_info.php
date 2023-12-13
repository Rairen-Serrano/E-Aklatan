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

    <title>Book Info Page</title>

</head>
<body>
    <!--one line code for navbar-->
    <div id="navbar-placeholder"></div>

    <div class="bookpage_container">
        <div class="GoBack">
            <a href="../html/books.php"><img src="../../images/angle-left-solid.svg" alt="LeftButton"></a>
            <a href="../html/books.php"><h4>&nbsp;&nbsp;&nbsp;GO BACK</h4></a>
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
                        <button>BORROW</button>
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