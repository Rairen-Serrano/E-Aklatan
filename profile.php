<?php 
    session_start();
    if(!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: login.php");
        die();
    }

    include 'dbconnect.php';

    $users_query = mysqli_query($dbconnect, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($users_query) > 0) {
        $users_row = mysqli_fetch_assoc($users_query);

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS link here-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    

    <!--Javascript link here-->
    <script defer src="js/script.js" ></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="js/jquery-3.7.1.js" defer></script>

    <title>Profile Page</title>
    
</head>
<body id="profile_page">
    <!--one line code for navbar-->
    <div id="navbar-placeholder"></div>

    <div class="profile_container">
        <div class="profile_sidebar">
            <div class="profile_info">
            <form action="" class="" enctype="multipart/form-data" method="post">
                <input type="hidden" name="id" value="<?php echo $users_row['UserID'] ?>">
                <div class="upload">
                    <?php 
                        $profilePicture = $users_row['profile_picture'];
                        if (empty($profilePicture)) {
                            $profilePicture = 'profile-picture.jpg';
                        }
                    ?>
                    <img src="images/<?php echo $profilePicture ?>" id="profile_picture">

                    <div class="rightRound" id="upload">
                        <input type="file" name="fileImg" id="fileImg" accept=".jpg, .jpeg, .png, .webp">
                        <i class="fa fa-camera"></i>
                    </div>

                    <div class="leftRound" id="cancel" style="display: none;">
                        <i class="fa fa-times"></i>
                    </div>

                    <div class="rightRound" id="confirm" style="display: none;">
                        <input type="submit" name="" value="">
                        <i class="fa fa-check"></i>
                    </div>

                </div>
            </form>


                <?php 
                    if(isset($_FILES["fileImg"]["name"])){
                        $user_id = $users_row['UserID'];
                        
                        $src = $_FILES["fileImg"]["tmp_name"];
                        $imageName = uniqid() .$_FILES["fileImg"]["name"];

                        $target = "images/" .$imageName;

                        if (is_uploaded_file($src)) {
                            move_uploaded_file($src, $target);
                            $profile_query = "UPDATE users SET profile_picture = '$imageName' WHERE UserID=$user_id";
                            mysqli_query($dbconnect, $profile_query);
                            header("Location: profile.php");
                        } else {
                            echo "File upload failed.";
                        }
                        
                    }
                ?>
                
                <h2><?php echo $users_row['name'] ?></h2>
            </div>







            <div class="profile_sidebarmenu">
                <ul>
                    <li id="dashboard">Dashboard</li>
                    <li id="read_later"> Read Later </li>
                    <li id="account">Account Details</li>
                    <li><a href="logout.php" style="text-decoration: none; color: black;">Logout</a></li>
                </ul>
            </div>



            <script>
                $(document).ready(function() {
                    // Initial content
                    $('#content').load('dashboard.php');

                    // Click event for dashboard links
                    $('#dashboard').click(function() {
                        $('#content').load('dashboard.php');
                    });

                    $('#account').click(function() {
                        $('#content').load('account_details.php');
                    });
                });
            </script>


        </div>
        <div class="profile_mainbar" id="content"></div>
    </div>



    <!--one line code for footer-->
    <div id="footer-placeholder"></div>
</body>
</html>