<header>
    <img class="logo" src="images/icon-removebg-preview.png" alt="logo">

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

        <div class="logout_container">
            <a href="logout.php" style="text-decoration: none; color: black;">Logout</a>
        </div>
</header>

<nav>
    <ul class="navbar-links">
        <li><a style="text-decoration: none" href="user_management.php">USER MANAGEMENT</a></li>
        <li><a style="text-decoration: none" href="user_logs.php">USER LOGS</a></li>
        <li><a style="text-decoration: none" href="borrowedbooks_management.php">BORROWED BOOKS MANAGEMENT</a></li>
        <li><a style="text-decoration: none" href="book_management.php">BOOKS MANAGEMENT</a></li>
    </ul> 
</nav>