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

    <title>EBook Info Page</title>

</head>
<body>
     <!--one line code for navbar-->
     <div id="navbar-placeholder"> </div>
    



     <div class="bookpage_container">
        <div class="GoBack">
            <a href="ebooks.php"><img src="images/angle-left-solid.svg" alt="LeftButton"></a>
            <a href="ebooks.php"><h4>&nbsp;&nbsp;&nbsp;GO BACK</h4></a>
        </div>


        <?php 
            include("dbconnect.php");
            $ebookinfo_sql="SELECT * FROM ebooks WHERE ebook_id=".$_GET['ebook_id'];

            if($ebookinfo_query=mysqli_query($dbconnect, $ebookinfo_sql)) {
                $ebookinfo_set=mysqli_fetch_assoc($ebookinfo_query);
                ?>


                <!--Book Info-->
                <div class="bookinfo_container">
                    <div class="bookFrontCover">
                        <?php
                            echo '<img src="data:image/jpeg;base64,'.base64_encode($ebookinfo_set['front_cover']).'"/>';
                        ?>  
                    </div>
                    
                    <div class="bookinfo-1">
                        <h2> <?php echo $ebookinfo_set['ebook_title'] ?> </h2>
                        <h5><strong>Published Date:</strong> <?php echo $ebookinfo_set ['published_year'] ?> </h5>
                        <h5><strong>Author:</strong> <?php echo $ebookinfo_set ['author'] ?> </h5>
                        <h5><strong>Genre:</strong> <?php echo $ebookinfo_set ['genre'] ?> </h5>
                        <h5><strong>Ratings:</strong> <?php echo $ebookinfo_set ['ratings'] ?> </h5>
                        <p><strong>Abstract:</strong> <?php echo $ebookinfo_set ['abstract'] ?> </p>                        

                        <?php
                            if($ebookinfo_set['ebook_id'] == 1){ ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1BB3AtTybgf9LQQasglHDeMKrwV-52KZX/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 2) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1OzLBjP_UzmSnUH4w8A1zJgPN0YZr-ji4/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 3) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1r5Uz1wotPgwS_s4X9BErl-GzQWpldBp3/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 4) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1njAWPX9MpRnONHfnfaFREJNxFFiJ8cdE/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 5) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1sCc_aMvltyDsCK5HWN5PSDoyw8ifmrUp/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 6) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/15ad1W9HmD1SQtHlHT8bKhoKwIQMzPrwU/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 7) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1Fneh3il7E4ggQfN83BKRVZDcTkoIepyv/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 8) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1J1Vq9cXax2NhwqUJN6TCdqyT5SsBdeuf/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 9) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1Pj_UdrexOsJ_wJmFH4vK1cvW0mg5fzgn/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 10) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1WExifHjSrIYDTql_LmaKokG_6eKF8OaT/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 11) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1lW00LSHYhJlFzX_hYhp5wpkKcDcjOK7-/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 12) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1g1tM6f1Sx7BtVuo2RQhRn9vGBcKAlNpr/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 13) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/14kteKB0QnPBq3g3aG3sh6iA7xyFyks2U/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 14) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1i_D_urUWt2S1arovyqe_uCVoyz2KSO2D/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 15) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1D1ci8uyu9ob0N8h58Ms4kUyRZqHIaj2m/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 16) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1SShEdNkghCR7SXV8x6j0U7XMn-bfoneP/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 17) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/19z8oLqiPUiJcGot1su2AOHQs1SHTCmJC/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 18) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1jE2jAwAY0eP_avMXH5bMo2QiJiulwSwH/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 19) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1JrpMfmsYCUzSkdeQ9U7uw5qBITGE_4up/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 20) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1fB8i_XSfO9j8AMgLtPPNqqODA19l-rh7/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 21) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1Xbw2pMcobTzhwtLbb4R4Z5oCtMdasZJP/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 22) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1oUc_d9AAy4fXShYfEmJ8p7BHzV6tr0tg/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 23) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1uvODirHl-k2cMCsZbDIo2BWbaOfTNoHr/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 24) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1T_E64vr4WDSMclNCi-hbvbXBDpD7vkN3/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } else if ($ebookinfo_set['ebook_id'] == 25) { ?>
                                <button class="borrow-button"><a target="_blank" href="https://drive.google.com/file/d/1xSfqquM_ALJ2yFn6WT3TCEcMBLTBSRG0/view?usp=drive_link" style="text-decoration: none; color: #FFF;">VIEW</a></button>
                            <?php } 
                        ?>

                        <!--here-->
                    </div>
                </div>  
            <?php } ?>
    </div>







    
    <!--one line code for footer-->
    <div id="footer-placeholder"></div>    
</body>
</html>