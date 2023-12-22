<?php
    $msg = "";

    include 'dbconnect.php';

    if (isset($_GET['reset'])) {
        if (mysqli_num_rows(mysqli_query($dbconnect, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
            if (isset($_POST['submit'])) {
                $password = mysqli_real_escape_string($dbconnect, md5($_POST['password']));
                $confirm_password = mysqli_real_escape_string($dbconnect, md5($_POST['confirm-password']));

                if ($password === $confirm_password) {
                    $users_query = mysqli_query($dbconnect, "UPDATE users SET password='{$password}', code='' WHERE code='{$_GET['reset']}'");

                    if($users_query) {
                        header("Location: login.php");
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
                }
            }
        } else {
            $msg = "<div class='alert alert-danger'>Reset Link do not match.</div>";
        }
    } else {
        header("Location: forgot-password.php");
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

    <title>Change Password Page</title>

</head>
<body>
  <!--one line code for navbar-->
  <div id="navbar-placeholder"></div>
    

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="../images/image3.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Change Password</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="password" class="password" name="password" placeholder="Enter Your New Password" required>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                            <button name="submit" class="btn" type="submit">Change Password</button>
                        </form>
                        <div class="social-icons">
                            <p>Back to! <a href="index.php">Login</a>.</p>
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
</body>
</html>