<?php
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: profile.php");
    die();
}

include("dbconnect.php");
$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($dbconnect, $_POST['admin_email']);
    $entered_password = $_POST['admin_password'];

    $admin_sql = "SELECT * FROM admin WHERE email=?";
    $stmt = mysqli_prepare($dbconnect, $admin_sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $admin_result = mysqli_stmt_get_result($stmt);

    if ($admin_result && mysqli_num_rows($admin_result) === 1) {
        $admin_row = mysqli_fetch_assoc($admin_result);
        $hashed_password = $admin_row['password'];

        // Debugging messages
        echo "Entered Password: " . $entered_password . "<br>";
        echo "Hashed Password from Database: " . $hashed_password . "<br>";

        // Verify the entered password against the hashed password
        if ($entered_password === $hashed_password) {
            // Password is correct
            header("Location: user_management.php");
            die();
        } else {
            // Password is incorrect
            $msg = "<div class='alert alert-danger'>Incorrect email or password.</div>";
        }
    } else {
        // No matching user found
        $msg = "<div class='alert alert-danger'>Incorrect email or password.</div>";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="../css/style.css">

    <!--Javascript link here-->
    <script defer src="../js/script.js" ></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/jquery-3.7.1.js" defer></script>
    <script src="https://kit.fontawesome.com/af562a2a63.js"></script>

    <title>Login Page</title>

</head>
<body1>
  <!--one line code for navbar-->
  <div id="navbar-placeholder"></div>
    


<!-- form section start -->
<section class="w3l-mockup-form">
    <div class="container">
        <!-- /form -->
        <div class="workinghny-form-grid">
            <div class="main-mockup">
                <div class="w3l_form align-self" style="background-color: #49808C;">
                    <div class="left_grid_info">
                        <img src="../images/admin-login.png" alt="">
                    </div>
                </div>
                <div class="content-wthree">
                    <h2>Hi Admin...</h2>
                    <p>"Empowering Minds, Enriching Souls – Administering the Gateway to Infinite Knowledge."</p>
                    <?php echo $msg; ?>
                    <form action="" method="post">
                        <input type="email" class="admin_email" name="admin_email" placeholder="Enter Your Email" required>
                        <input type="password" class="admin_password" name="admin_password" placeholder="Enter Your Password" style="margin-bottom: 2px;" required>
                        <button name="submit" name="submit" class="btn" type="submit" style="background: #49808C;">Login</button>
                    </form>
                    <div class="social-icons">
                        <p>Are you an user? Log in here: <a href="login.php" style="text-decoration: none; color: #0097B2;">User Account</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- //form -->
    </div>
</section>
<!-- //form section start -->




  <!--one line code for footer-->
  <div id="footer-placeholder"></div>
</body1>
</html>