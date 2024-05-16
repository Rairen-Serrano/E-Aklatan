<?php 
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();
    if(isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: profile.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    include("dbconnect.php");
    $msg = "";
    $password_creation_date = date('Y-m-d'); 

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($dbconnect, $_POST['name']);
        $email = mysqli_real_escape_string($dbconnect, $_POST['email']);
        $password = mysqli_real_escape_string($dbconnect, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($dbconnect, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($dbconnect, md5(rand()));

        if (mysqli_num_rows(mysqli_query($dbconnect, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
            $msg = "<div class = 'alert alert-danger'>{$email} - This email address is already exists.</div>";
        } else {
            if ($password === $confirm_password) {
                $users_sql = "INSERT INTO users (name, email, password, code, password_creation_date) 
                VALUES ('{$name}', '{$email}', '{$password}', '{$code}', '{$password_creation_date}')";
                $users_query = mysqli_query($dbconnect, $users_sql);
                
                if ($users_query) {
                    // Insert initial data into account_details table
                    $account_details_sql = "INSERT INTO account_details (UserID, first_name, email) VALUES (LAST_INSERT_ID(), '{$name}','{$email}')";
                    $account_details_query = mysqli_query($dbconnect, $account_details_sql);
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
                        $mail->Body    = 'Here is the verification link <b><a href="http://localhost:3000/login.php?verification='.$code.'">http://localhost:3000/login.php?verification='.$code.'</a></b>';

                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {

                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div";
                    $msg = "<div class = 'alert alert-info'>We've send a verification link on your email address.</div>";
                } else {
                    $msg = "<div class = 'alert alert-danger'>Something went wrong.</div>";
                }
            } else {
                ?>
                

                <?php
                $msg = "<div class = 'alert alert-danger'>Password and Confirm Password do not match.</div>";
            }
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
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--Javascript link here -->
    <script src="js/script.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="js/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/af562a2a63.js"></script>

    <title>Register Page</title>

</head>
<body id="registerPage">
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
                            <img src="images/register-img-removebg-preview.png" alt="" style="width: 600px;">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Register Now</h2>
                        <p>"Elevate Your Reading Experience: Enroll with E-Aklatan and Open a Portal to Infinite Knowledge!" </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="name" name="name" placeholder="Enter Full Name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                            <input type="password" id="register_password1" class="password" name="password" placeholder="Enter Your Password" onkeyup="return validate()" required>
                            <img src="images/eye-close.png" id="eyeicon1" style="top: 319px">
                            <div class="password_errors">
                                <ul>
                                    <li id="upper">Atleast one uppercase</li>
                                    <li id="lower">Atleast one lowercase</li>
                                    <li id="special_char">Atleast one special character</li>
                                    <li id="number">Atleast one number</li>
                                    <li id="length">Atleast 6 characters</li>
                                </ul>
                            </div>
                            <input type="password" id="register_password2" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                            <img src="images/eye-close.png" id="eyeicon2" style="top: 483px">
                            <button name="submit" class="btn" type="submit">Register</button>
                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="login.php" style="text-decoration: none; color: #0097B2;">Login</a>.</p>
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