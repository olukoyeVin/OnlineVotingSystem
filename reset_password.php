<?php
require_once("admin/inc/config.php");

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

<!-- Add this form inside your existing HTML code -->
<div class="d-flex justify-content-center form_container">
    <form method="POST" action="">
        <div class="input-group mb-2">
            <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" name="new_password" class="form-control input_pass" placeholder="New Password" required />
        </div>
        <div class="d-flex justify-content-center mt-3 login_container">
            <button type="submit" name="reset_password_btn" class="btn login_btn">Reset Password</button>
        </div>
    </form>
</div>
