<?php
    session_start();
    if(isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: profile.php");
        die();
    }

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require '../vendor/autoload.php';

    include 'dbconnect.php';
    $msg = "";

    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($dbconnect, $_POST['email']);
        $code = mysqli_real_escape_string($dbconnect, md5(rand()));

        if (mysqli_num_rows(mysqli_query($dbconnect, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
            $users_query = mysqli_query($dbconnect, "UPDATE users SET code='{$code}' WHERE email='{$email}'");

            if ($users_query) {
                echo "<div style='display: none;'>";
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'makati.eaklatan123@gmail.com';         //SMTP username
                    $mail->Password   = 'jlbf jtkm ymif ebop';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('makati.eaklatan123@gmail.com');
                    $mail->addAddress($email);

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'no reply';
                    $mail->Body    = 'Here is the verification link <b><a href="http://localhost:3000/html/change-password.php?reset='.$code.'">http://localhost:3000/html/change-password.php?reset='.$code.'</a></b>';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                echo "</div";
                $msg = "<div class = 'alert alert-info'>We've send a verification link on your email address.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>$email - Sorry, there is no record of this email address.</div>";
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

    <title>ForgotPassword Page</title>

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
                            <img src="../images/forgot_password-img-removebg-preview.png" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Forgot Password</h2>
                        <p>Always secure your accounts: Reset your password in E-Aklatan. </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                            <button name="submit" class="btn" type="submit">Send Reset Link</button>
                        </form>
                        <div class="social-icons">
                            <p>Back to! <a href="login.php" style="text-decoration: none; color: #0097B2;">Login</a>.</p>
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