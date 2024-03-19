<?php 
    require_once("admin/inc/config.php");

    $fetchingElections = mysqli_query($db, "SELECT * FROM elections") OR die(mysqli_error($db));
    while($data = mysqli_fetch_assoc($fetchingElections))
    {
        $stating_date = $data['starting_date'];
        $ending_date = $data['ending_date'];
        $curr_date = date("Y-m-d");
        $election_id = $data['id'];
        $status = $data['status'];

        // Active = Expire = Ending Date
        // InActive = Active = Starting Date

        if($status == "Active")
        {
            $date1=date_create($curr_date);
            $date2=date_create($ending_date);
            $diff=date_diff($date1,$date2);
            
            if((int)$diff->format("%R%a") < 0)
            {
                // Update! 
                mysqli_query($db, "UPDATE elections SET status = 'Expired' WHERE id = '". $election_id ."'") OR die(mysqli_error($db));
            }
        }else if($status == "InActive")
        {
            $date1=date_create($curr_date);
            $date2=date_create($stating_date);
            $diff=date_diff($date1,$date2);
            

            if((int)$diff->format("%R%a") <= 0)
            {
                // Update! 
                mysqli_query($db, "UPDATE elections SET status = 'Active' WHERE id = '". $election_id ."'") OR die(mysqli_error($db));
            }
        }
        

    }
    if (isset($_POST['forgot_password_btn'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $fetchingData = mysqli_query($db, "SELECT * FROM users WHERE email = '$email'");

        if (mysqli_num_rows($fetchingData) > 0) {
            $user = mysqli_fetch_assoc($fetchingData);
            $reset_token = bin2hex(random_bytes(16));

            // Update the user record with the reset token
            mysqli_query($db, "UPDATE users SET reset_token = '$reset_token' WHERE email = '$email'");

            // Send a password reset email to the user
            $reset_link = "http://yourdomain.com/reset_password.php?token=$reset_token";
            $subject = "Password Reset Request";
            $message = "Click on the following link to reset your password: $reset_link";
            $headers = "From: your_email@example.com";

            mail($email, $subject, $message, $headers);

            // Redirect the user with a success message
            header("Location: index.php?password_reset=success");
            exit();
        } else {
            // Redirect the user with an error message
            header("Location: index.php?password_reset=error");
            exit();
        }
    }

    if (isset($_GET['token'])) {
        $token = mysqli_real_escape_string($db, $_GET['token']);
        $fetchingData = mysqli_query($db, "SELECT * FROM users WHERE reset_token = '$token'");

        if (mysqli_num_rows($fetchingData) > 0) {
            $user = mysqli_fetch_assoc($fetchingData);

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password_btn'])) {
                $new_password = mysqli_real_escape_string($db, $_POST['new_password']);
                $hashed_password = sha1($new_password);

                // Update the user's password and clear the reset token
                mysqli_query($db, "UPDATE users SET password = '$hashed_password', reset_token = NULL WHERE id = " . $user['id']);

                // Redirect the user with a success message
                header("Location: index.php?password_reset=success");
                exit();
            }
        } else {
            // Redirect the user with an error message
            header("Location: index.php?password_reset=error");
            exit();
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
	<title>Login - Online Voting System</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="assets/images/logo.gif" class="brand_logo" alt="Logo">
					</div>
				</div>

                <?php 
                    if(isset($_GET['sign-up']))
                    {
                ?>
                                <div class="d-flex justify-content-center form_container">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="first_name" class="form-control input_user" placeholder="First Name" required />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="last_name" class="form-control input_user" placeholder="Last Name" required />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input type="text" name="id_number" class="form-control input_user" placeholder="ID Number" required />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control input_user" placeholder="Email" required />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                </div>
                                <input type="text" name="place_of_birth" class="form-control input_user" placeholder="Place of Birth" required />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                                </div>
                                <input type="file" name="photo" class="form-control input_user" accept="image/*" required />
                            </div>
                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="submit" name="sign_up_btn" class="btn login_btn">Apply</button>
                            </div>
                        </form>
                    </div>
                                    
                        <div class="mt-4">
                            <div class="d-flex justify-content-center links text-white">
                                Already Created Account? <a href="index.php" class="ml-2 text-white">Sign In</a>
                            </div>
                        </div>
                <?php
                    }else {
                ?>
                        <div class="d-flex justify-content-center form_container">
                            <form method="POST">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="contact_no" class="form-control input_user" placeholder="Contact No" required />
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control input_pass" placeholder="Password" required />
                                </div>
                                    <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="loginBtn" class="btn login_btn">Login</button>
                        </div>
                            </form>   
                        </div>
                
                        <div class="mt-4">
                            <div class="d-flex justify-content-center links text-white">
                                Don't have an account? <a href="?sign-up=1" class="ml-2 text-white">Sign Up</a>
                            </div>
                            <div class="d-flex justify-content-center links">
                                <a href="?forgot-password=1" class="text-white">Forgot your password?</a>
                            </div>
                        </div>
                <?php
                    }
                    
                ?>

                <?php 
                    if(isset($_GET['registered']))
                    {
                ?>
                        <span class="bg-white text-success text-center my-3"> Your account has been created successfully! </span>
                <?php
                    }else if(isset($_GET['invalid'])) {
                ?>
                        <span class="bg-white text-danger text-center my-3"> Passwords mismatched, please try again! </span>
                <?php
                    }else if(isset($_GET['not_registered'])) {
                ?>
                        <span class="bg-white text-warning text-center my-3"> Sorry, you are not registered! </span>
                <?php
                    }else if(isset($_GET['invalid_access'])) {
                ?>
                        <span class="bg-white text-danger text-center my-3"> Invalid username or password! </span>
                <?php
                    }
                ?>
                       
			</div>
		</div>
	</div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>
</html>

<?php 
    require_once("admin/inc/config.php");

    if(isset($_POST['sign_up_btn']))
    {
        $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
        $id_number = mysqli_real_escape_string($db, $_POST['id_number']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $place_of_birth = mysqli_real_escape_string($db, $_POST['place_of_birth']);
        $photo = $_FILES['photo']['name'];
        $temp_photo = $_FILES['photo']['tmp_name'];
        $upload_path = "/assets/images/user_photos/";
    
        move_uploaded_file($temp_photo, $upload_path.$photo);

        if($su_password == $su_retype_password)
        {
            // Insert Query 

            mysqli_query($db, "INSERT INTO voter_application (first_name, last_name, id_number, email, place_of_birth, photo) VALUES ('$first_name', '$last_name', '$id_number', '$email', '$place_of_birth', '$photo')") or die(mysqli_error($db));


        ?>
            <script> location.assign("index.php?sign-up=1&registered=1"); </script>
        <?php

        }else {
    ?>
            <script> location.assign("index.php?sign-up=1&invalid=1"); </script>
    <?php
        }
             
    }else if(isset($_POST['loginBtn']))
    {
        $contact_no = mysqli_real_escape_string($db, $_POST['contact_no']);
        $password = mysqli_real_escape_string($db, sha1($_POST['password']));
        

        // Query Fetch / SELECT
        $fetchingData = mysqli_query($db, "SELECT * FROM users WHERE contact_no = '". $contact_no ."'") or die(mysqli_error($db));

        
        if(mysqli_num_rows($fetchingData) > 0)
        {
            $data = mysqli_fetch_assoc($fetchingData);

            if($contact_no == $data['contact_no'] AND $password == $data['password'])
            {
                session_start();
                $_SESSION['user_role'] = $data['user_role'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['user_id'] = $data['id'];
                
                if($data['user_role'] == "Admin")
                {
                    $_SESSION['key'] = "AdminKey";
            ?>
                    <script> location.assign("admin/index.php?homepage=1"); </script>
            <?php
                }else {
                    $_SESSION['key'] = "VotersKey";
            ?>
                    <script> location.assign("voters/index.php"); </script>
            <?php
                }

            }else {
        ?>
                <script> location.assign("index.php?invalid_access=1"); </script>
        <?php
            }


        }else {
    ?>
            <script> location.assign("index.php?sign-up=1&not_registered=1"); </script>
    <?php

        }

    }

?>