<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="../css/style.css">

    <!--Javascript link here-->
    <script defer src="../js/script.js" ></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="../js/jquery-3.7.1.js" defer></script>

    <title>Landing Page</title>
</head>
<body id="LandingPage">
    <!--one line code for navbar-->
    <div id="navbar-placeholder"></div>


    <!-- include the dbconnect.php for call the database -->
    <?php
        include("dbconnect.php");
    ?>

    <!--Carousel-->
    <div class="img-slider">
        <div class="slide active">
            <img src="../images/carousel-background-1.jpg" alt="">
            <div class="info">
                <p>Remotely check what books are available in the library.</p>
            </div>
        </div>

        <div class="slide">
            <img src="../images/carousel-background-2.jpg" alt="">
            <div class="info">
                <p>Borrow Book Online.</p>
            </div>
        </div>

        <div class="slide">
            <img src="../images/carousel-background-3.jpg" alt="">
            <div class="info">
                <p>Access to Thousand of Free Ebooks<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;Download or Read Only</p>
            </div>
        </div>

        <div class="slide">
            <img src="../images/carousel-background-4.jpg" alt="">
            <div class="info">
                <p>Multiple Source of Journals and Articles</p>
            </div>
        </div>

        <div class="slide">
            <img src="../images/carousel-background-5.jpg" alt="">
            <div class="info">
                <p>Makati City Local History Unit</p>
            </div>
        </div>
        <div class="navigation">
            <div class="btn active"></div>
            <div class="btn"></div>
            <div class="btn"></div>
            <div class="btn"></div>
            <div class="btn"></div>
        </div>
    </div>

    <!-- Brief About Us -->
    <div class="about_container">
        <img src="../images/about_img.jpg" alt="about_us_image">
        <div class="brief_aboutUs">
            <h2>What is E-Aklatan?</h2>
            <p>Welcome to E-Aklatan: Makati City Library Learning Commons, 
                your gateway to a world of knowledge and learning. E-Aklatan is more than 
                just an electronic library; it's a vibrant hub of resources and opportunities 
                designed to empower individuals in their pursuit of education, research, and personal 
                growth. With E-Aklatan you have access to all kind books, ebooks, and journals online</p>
            <a href="../html/aboutUs.html"><button type="button"> MORE </button></a>
        </div>
    </div>







    <!-- TOP BOOKS -->
    <div class="topBooks_Title"><h1>TOP BOOKS</h1></div>
    <div class="topbooks_container">
        <div class="topbooks_wrapper">
            <img id="leftbutton" src="../images/angle-left-solid.svg" alt="LeftAngle" class="arrowBtn"></img>
            
            <?php 
                $Topbooks_sql="SELECT BookID, FrontCover, BookTitle, Ratings FROM books WHERE GenreID='5' or GenreID='6' ORDER BY BOOKID LIMIT 10";
                $Topbooks_query=mysqli_query($dbconnect, $Topbooks_sql);
                $Topbooks_set=mysqli_fetch_assoc($Topbooks_query);
                
            ?>

            <div class="topbooks_carousel">
                <?php
                    do{ ?>
                    <div class="frontcover">
                        <a href="../html/book_info.php?BookID=<?php echo $Topbooks_set['BookID']?>"> 
                        <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($Topbooks_set['FrontCover']).'"/>'; ?>
                        <h2><?php echo $Topbooks_set['BookTitle']; ?></h2>
                        <h5><?php echo $Topbooks_set['Ratings']; ?></h5> </a>

                        <div class="seemore_container">
                            <a href="../html/book_info.php?BookID=<?php echo $Topbooks_set['BookID']?>"><span>SEE MORE</span><img src="../images/angle-right-solid.svg" alt="rightbtn"></a>
                        </div>
                    </div>
                <?php
                    }while($Topbooks_set=mysqli_fetch_assoc($Topbooks_query)); ?>
            </div>
            <img id="rightbutton" src="../images/angle-right-solid.svg" alt="RightAngle" class="arrowBtn"></img>
        </div>
    </div>

    









    <!-- Library News and Updates Carousel -->
    <div class="NewAndUpdateTitle"><h1>NEWS & UPDATES</h1></div>

    <div class="NewAndUpdate_container">
        <div class="NewsAndUpdate_wrapper">
            <img id="leftbtn" src="../images/angle-left-solid.svg" alt="LeftAngle" class="arrowButton"></img>
            <ul class="NewsAndUpdate_carousel">
                <li class="cards">
                    <div class="newsimage_container">
                        <img src="../images/News&Update/NewsImg.png" alt="">
                    </div>
                    <h2>Removed Books <br>Week: October 20</h2>
                    <span>Oct 20, 2023</span>
                    <a href="../html/news/RemovedBooks-Oct20.html"><button type="button"> View more... </button></a>
                </li>
                <li class="cards">
                    <div class="newsimage_container">
                        <img src="../images/News&Update/friendsDay.jpg" alt="">
                    </div>
                    <h2>Celebrating National Friends <br>of Libraries Week: October 15-21</h2>
                    <span>Oct 15, 2023</span>
                    <a href="../html/news/NationalFriends-Oct15.html"><button type="button"> View more... </button></a>
                </li>
                <li class="cards">
                    <div class="newsimage_container">
                        <img src="../images/News&Update/SystemUpdate.png" alt="">
                    </div>
                    <h2>System Update <br>Week: October 1</h2>
                    <span>Oct 1, 2023</span>
                    <a href="../html/news/SystemUpdate-Oct1.html"><button type="button"> View more... </button></a>
                </li>
                <li class="cards">
                    <div class="newsimage_container">
                        <img src="../images/News&Update/AddedBooks.jpg" alt="">
                    </div>
                    <h2>Added Ebooks and Journals Week: September 15</h2>
                    <span>Sept 15, 2023</span>
                    <a href="../html/news/AddedBooks-Sept15.html"><button type="button"> View more... </button></a>
                </li>
                <li class="cards">
                    <div class="newsimage_container">
                        <img src="../images/News&Update/Newspaper.jpg" alt="">
                    </div>
                    <h2>Newly Published Newspaper Week: September 1</h2>
                    <span>Sept 1, 2023</span>
                    <a href="../html/news/Newspaper-Sept1.html"><button type="button"> View more... </button></a>
                </li>
            </ul>
            <img id="rightbtn" src="../images/angle-right-solid.svg" alt="RightAngle" class="arrowButton"></img>
        </div>
    </div>

    <!--one line code for footer-->
    <div id="footer-placeholder"></div>
</body>
</html>