<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="../css/style.css">

    <!--Javascript link here -->
    <script src="../js/script.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <title>EBook Info Page</title>

</head>
<body>
     <!--one line code for navbar-->
     <div id="navbar-placeholder"> </div>
    



     <div class="bookpage_container">
        <div class="GoBack">
            <a href="../html/ebooks.php"><img src="../images/angle-left-solid.svg" alt="LeftButton"></a>
            <a href="../html/ebooks.php"><h4>&nbsp;&nbsp;&nbsp;GO BACK</h4></a>
        </div>


        <?php 
            include("dbconnect.php");
            $journalinfo_sql="SELECT * FROM journals WHERE journal_id=".$_GET['journal_id'];

            if($journalinfo_query=mysqli_query($dbconnect, $journalinfo_sql)) {
                $journalinfo_set=mysqli_fetch_assoc($journalinfo_query);
                ?>


                <!--Book Info-->
                <div class="bookinfo_container">
                    <div class="bookFrontCover">
                        <?php
                            echo '<img src="data:image/jpeg;base64,'.base64_encode($journalinfo_set['front_cover']).'"/>';
                        ?>  
                    </div>
                    
                    <div class="bookinfo-1">
                        <h2> <?php echo $journalinfo_set['journal_title'] ?> </h2>
                        <h5><strong>Publisher:</strong> <?php echo $journalinfo_set ['publisher'] ?> </h5>
                        <h5><strong>Category:</strong> <?php echo $journalinfo_set ['category'] ?> </h5>
                        <h5><strong>Citation:</strong> <?php echo $journalinfo_set ['citation'] ?> </h5>
                        <p><strong>Description:</strong> <?php echo $journalinfo_set ['description'] ?> </p>                      


                        <?php
                            if($journalinfo_set['journal_id'] == 1){ ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/10VjWn8yeq-uDt0AZR5SQbPGUdcilY3QR/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            
                            <?php } else if ($journalinfo_set['journal_id'] == 2){ ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1e4ABNH66hYumc__gFKoiiGf2OSJAuBGO/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                                
                            <?php } else if ($journalinfo_set['journal_id'] == 3){ ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1bRmmeWd6DmLZn7w73rU-xCXJxwxUOo4D/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
    
                            <?php }?>

                    </div>
                </div>  
            <?php } ?>
    </div>







    
    <!--one line code for footer-->
    <div id="footer-placeholder"></div>    
</body>
</html>