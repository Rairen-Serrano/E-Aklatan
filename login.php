<?php 
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: profile.php");
    die();
}

include("dbconnect.php");

date_default_timezone_set('Asia/Manila');

$msg = "";

if (isset($_GET['verification'])) {
    $verification_code = mysqli_real_escape_string($dbconnect, $_GET['verification']);
    $result = mysqli_query($dbconnect, "SELECT * FROM users WHERE code = '$verification_code'");
    if (mysqli_num_rows($result) > 0) {
        $update_query = mysqli_query($dbconnect, "UPDATE users SET code='' WHERE code='$verification_code'");
        if ($update_query) {
            $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
        }
    } else {
        header("Location: login.php");
        exit();
    }
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($dbconnect, $_POST['email']);
    $password = mysqli_real_escape_string($dbconnect, md5($_POST['password']));
    
    $users_sql = "SELECT * FROM users WHERE email='$email'";
    $users_result = mysqli_query($dbconnect, $users_sql);

    if (mysqli_num_rows($users_result) === 1) {
        $users_row = mysqli_fetch_assoc($users_result);
        $failed_attempts = $users_row['failed_attempts'];
        $lock_until = $users_row['lock_until'];

        // Check if the account is locked
        if ($lock_until && strtotime($lock_until) > time()) {
            $msg = "<div class='alert alert-danger'>You have entered a lot of incorrect passwords. Please try again after " . date('l, g:i:s A, Y-m-d', strtotime($lock_until)) . ".</div>";
        } else {
            // Reset failed attempts and lock_until if lockout period has expired
            if ($failed_attempts >= 5 && strtotime($lock_until) <= time()) {
                $failed_attempts = 0;
                $lock_until = null;
                mysqli_query($dbconnect, "UPDATE users SET failed_attempts = 0, lock_until = NULL WHERE email='$email'");
            }

            // Verify password
            if ($users_row['password'] === $password) {
                // Reset failed attempts upon successful login
                $failed_attempts = 0;
                $lock_until = null;
                mysqli_query($dbconnect, "UPDATE users SET failed_attempts = 0, lock_until = NULL WHERE email='$email'");

                $update_login_time = "UPDATE users SET time_log_in = NOW(), time_log_out = NULL WHERE email = '$email'";
                mysqli_query($dbconnect, $update_login_time);

                $password_creation_date = strtotime($users_row['password_creation_date']);
                $current_date = strtotime(date('Y-m-d'));
                $expiry_date = strtotime('+1 year', $password_creation_date);

                if ($current_date > $expiry_date) {
                    header("Location: expired-password.php?message=expired");
                    exit();
                }

                if (empty($users_row['code'])) {
                    $_SESSION['SESSION_EMAIL'] = $email;
                    header("Location: profile.php");
                    exit();
                } else {
                    $msg = "<div class='alert alert-info'>Verify your account first and try again.</div>";
                }
            } else {
                $failed_attempts++;
                $msg = "<div class='alert alert-danger'>Incorrect email or password.</div>";

                if ($failed_attempts >= 5) {
                    $lock_until = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                }

                $update_attempts_query = "UPDATE users SET failed_attempts = $failed_attempts, lock_until = '$lock_until' WHERE email='$email'";
                mysqli_query($dbconnect, $update_attempts_query);
            }
        }
    } else {
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
    <link rel="stylesheet" href="css/style.css">

    <!--Javascript link here-->
    <script defer src="js/script.js" ></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="js/jquery-3.7.1.js" defer></script>
    <script src="https://kit.fontawesome.com/af562a2a63.js"></script>

    <title>Login Page</title>

</head>
<body id="login_page">
  <!--one line code for navbar-->
  <div id="navbar-placeholder"></div>
    



  <section class="w3l-mockup-form">
      <div class="container">
          <div class="workinghny-form-grid">
              <div class="main-mockup">
                  <div class="w3l_form align-self">
                      <div class="left_grid_info">
                          <img src="images/Login-img-removebg.png" alt="">
                      </div>
                  </div>
                  <div class="content-wthree">
                      <h2>Login Now</h2>
                      <p>"Dive into Wisdom: Open the Chapters of Knowledge, Log into E-Aklatan!"</p>
                      <?php echo $msg; ?>
                      <form action="" method="post">
                          <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                        <div class="password-container">
                            <input type="password" id="user_password" class="password" name="password" placeholder="Enter Your Password" onkeyup="return validate()" required>
                            <img src="images/eye-close.png" id="eye_icon" class="eye-icon" onclick="togglePasswordVisibility('register_password1', 'eyeicon1')">
                        </div>
                          <p><a href="forgot-password.php" style="margin-bottom: 15px; display: block; text-align: right; color :#0097B2; text-decoration: none;">Forgot Password?</a></p>
                          <button name="submit" name="submit" class="btn" type="submit">Login</button>
                      </form>
                      <div class="social-icons">
                          <p>Create Account! <a href="register.php" style="text-decoration: none; color: #0097B2;">Register</a>.</p>
                          <p>Are you an admin? Log in here: <a href="admin_login.php" style="text-decoration: none; color: #0097B2;">Admin Account</a></p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>




  <!--one line code for footer-->
  <div id="footer-placeholder"></div>
</body>
</html>