<?php 
require_once("admin/inc/config.php");

// Update Election Status
$fetchingElections = mysqli_query($db, "SELECT * FROM elections") OR die(mysqli_error($db));
while($data = mysqli_fetch_assoc($fetchingElections))
{
    $stating_date = $data['starting_date'];
    $ending_date = $data['ending_date'];
    $curr_date = date("Y-m-d");
    $election_id = $data['id'];
    $status = $data['status'];

    if($status == "Active")
    {
        $date1=date_create($curr_date);
        $date2=date_create($ending_date);
        $diff=date_diff($date1,$date2);
        
        if((int)$diff->format("%R%a") < 0)
        {
            mysqli_query($db, "UPDATE elections SET status = 'Expired' WHERE id = '". $election_id ."'") OR die(mysqli_error($db));
        }
    }
    else if($status == "InActive")
    {
        $date1=date_create($curr_date);
        $date2=date_create($stating_date);
        $diff=date_diff($date1,$date2);
        

        if((int)$diff->format("%R%a") <= 0)
        {
            mysqli_query($db, "UPDATE elections SET status = 'Active' WHERE id = '". $election_id ."'") OR die(mysqli_error($db));
        }
    }
}

// User Sign-Up
if(isset($_POST['sign_up_btn']))
{
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $id_number = mysqli_real_escape_string($db, $_POST['id_number']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $place_of_birth = mysqli_real_escape_string($db, $_POST['place_of_birth']);
    $contact_no = mysqli_real_escape_string($db, $_POST['contact_no']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);

    if($password == $confirm_password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($db, "INSERT INTO voter_application (first_name, last_name, id_number, email, place_of_birth, contact_no, password) VALUES ('$first_name', '$last_name', '$id_number', '$email', '$place_of_birth', '$contact_no', '$hashedPassword')") or die(mysqli_error($db));
        ?>
            <script> location.assign("index.php?sign-up=1&registered=1"); </script>
        <?php
    }
    else
    {
        ?>
            <script> location.assign("index.php?sign-up=1&invalid=1"); </script>
        <?php
    }
}
// User Login       
    else if(isset($_POST['loginBtn']))
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
                        <form method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="first_name" class="form-control input_user" placeholder="First Name" required />
                            </div>
                            <!-- Add Last Name -->
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="last_name" class="form-control input_user" placeholder="Last Name" required />
                            </div>
                            <!-- Add ID Number -->
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input type="text" name="id_number" class="form-control input_user" placeholder="ID Number" required />
                            </div>
                            <!-- Add Email -->
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control input_user" placeholder="Email" required />
                            </div>
                            <!-- Add Place of Birth -->
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class"fas fa-globe"></i></span>
                                </div>
                                <input type="text" name="place_of_birth" class="form-control input_user" placeholder="Place of Birth" required />
                                </div>
                                <!-- Add Contact Number -->
                                <div class="input-group mb-3">
                                <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" name="contact_no" class="form-control input_user" placeholder="Contact Number" required />
                                </div>
                                <!-- Add Password -->
                                <div class="input-group mb-3">
                                <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control input_pass" placeholder="Password" required />
                                </div>
                                <!-- Add Confirm Password -->
                                <div class="input-group mb-3">
                                <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" name="confirm_password" class="form-control input_pass" placeholder="Confirm Password" required />
                                </div>
                                <!-- Submit Button -->
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
                        }
                        else
                        {
                    ?>
                        <div class="d-flex justify-content-center form_container">
                            <form method="POST">
                                <!-- Contact Number -->
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" name="contact_no" class="form-control input_user" placeholder="Contact No" required />
                                </div>
                                <!-- Password -->
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control input_pass" placeholder="Password" required />
                                </div>

                                <!-- Submit Button -->
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

                    <!-- Registration Success/Error Messages -->
                    <?php 
                        if(isset($_GET['registered']))
                        {
                    ?>
                            <span class="bg-white text-success text-center my-3"> Your account has been created successfully! </span>
                    <?php
                        }
                        else if(isset($_GET['invalid']))
                        {
                    ?>
                            <span class="bg-white text-danger text-center my-3"> Passwords mismatched, please try again! </span>
                    <?php
                        }
                        else if(isset($_GET['not_registered']))
                        {
                    ?>
                            <span class="bg-white text-warning text-center my-3"> Sorry, you are not registered! </span>
                    <?php
                        }
                        else if(isset($_GET['invalid_access']))
                        {
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
