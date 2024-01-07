    <header>
        <img class="logo" src="../images/icon-removebg-preview.png" alt="logo">

        <div class="slogan">
            <strong>M</strong>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;YOUR LOCAL GATEWAY TO INFORMATION<br><span>AKATI CITY PUBLIC LIBRARY</span></p>
        </div>

        <?php 
            session_start();
            include "dbconnect.php";

            // Check if the user is logged in
            if (isset($_SESSION['SESSION_EMAIL'])) {
                // User is logged in, fetch user data
                $email = mysqli_real_escape_string($dbconnect, $_SESSION['SESSION_EMAIL']);
                $users_query = mysqli_query($dbconnect, "SELECT * FROM users WHERE email='$email'");

                if (mysqli_num_rows($users_query) > 0) {
                    $users_row = mysqli_fetch_assoc($users_query);
                }
            }
            ?>

            <!-- Navbar based on user login status -->
            <?php if (!isset($_SESSION['SESSION_EMAIL'])) { ?>
            <ul class="navbar-register">
                <li><a style="text-decoration: none" href="../html/login.php">Login</a></li>
                <li><a style="text-decoration: none" href="../html/register.php">Signup</a></li>
            </ul> 
            <?php } else { ?>
            <div class="navbar_profile">
                <a href="../html/profile.php"><img src="../images/user-regular.svg" alt=""></a>
                <a href="../html/profile.php"><p><?php echo $users_row['name'] ?></p></a>
            </div> 
        <?php } ?>

    </header>

    

    <!--<nav class="navbar-container">-->
    <nav>
        <ul class="navbar-links">
            <li><a style="text-decoration: none" href="../html/index.php">HOME</a></li>
            <li><a style="text-decoration: none" href="../html/books.php">BOOKS</a></li>
            <li><a style="text-decoration: none" href="../html/ebooks.php">EBOOKS</a></li>
            <li><a style="text-decoration: none" href="../html/journal.html">JOURNALS</a></li>
            <li><a style="text-decoration: none" href="../html/newspaper.html">NEWSPAPER</a></li>
            <li><a style="text-decoration: none" href="#">ABOUT US</a>
                <ul id="submenu">
                    <li><a href="../html/aboutUs.html">About City Library</a></li>
                    <li><a href="../html/briefHistory.html">Brief History</a></li>
                    <li><a href="../html/mission&vision.html">Mission & Vision</a></li>
                    <li><a href="../html/contactUs.html">Contact Us</a></li>
                    <li><a target="_blank" href="https://drive.google.com/file/d/1irBJCSH4AvPyVgZTg33aP2SzwxzOKgKW/view?usp=drive_link">Citizen's Charter</a></li>
                </ul>    
            </li>
        </ul> 
    </nav>