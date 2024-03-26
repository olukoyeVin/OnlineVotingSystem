<?php
require_once("admin/inc/config.php");
require_once(__DIR__ . '/admin/inc/vendor/autoload.php');

if(isset($_POST['verify_btn']))
{
    $contact_no = mysqli_real_escape_string($db, $_POST['contact_no']);
    $entered_otp = mysqli_real_escape_string($db, $_POST['otp']);

    // Check if the entered OTP is correct
    $check_otp = mysqli_query($db, "SELECT * FROM otp WHERE contact_no = '$contact_no' AND otp = '$entered_otp' AND NOW() <= DATE_ADD(created_at, INTERVAL 5 MINUTE)") or die(mysqli_error($db));

    if(mysqli_num_rows($check_otp) > 0)
    {
        // OTP is correct
        // Fetch user details from the 'users' table
        $fetch_user = mysqli_query($db, "SELECT * FROM users WHERE contact_no = '$contact_no'") or die(mysqli_error($db));
        $user_data = mysqli_fetch_assoc($fetch_user);

        // Start the session and store user details
        session_start();
        $_SESSION['user_role'] = $user_data['user_role'];
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['user_id'] = $user_data['id'];

        if($user_data['user_role'] == "Admin")
        {
            $_SESSION['key'] = "AdminKey";
            ?>
            <script> location.assign("admin/index.php?homepage=1"); </script>
            <?php
        }
        else
        {
            $_SESSION['key'] = "VotersKey";
            ?>
            <script> location.assign("voters/index.php"); </script>
            <?php
        }
    }
    else
    {
        // Invalid OTP
        echo "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification - Online Voting System</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="mt-5">OTP Verification</h2>
                <form method="POST">
                    <input type="hidden" name="contact_no" value="<?php echo $_GET['contact_no']; ?>">
                    <div class="form-group">
                        <label for="otp">Enter OTP:</label>
                        <input type="text" class="form-control" id="otp" name="otp" required>
                    </div>
                    <button type="submit" name="verify_btn" class="btn btn-primary">Verify OTP</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
