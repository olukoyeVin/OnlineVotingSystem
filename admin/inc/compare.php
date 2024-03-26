<?php
include("config.php"); // Include database connection

$idNumber = mysqli_real_escape_string($db, $_POST['id_number']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$placeOfBirth = mysqli_real_escape_string($db, $_POST['place_of_birth']);

$result = mysqli_query($db, "SELECT * FROM `database` WHERE id_number='$idNumber' AND email='$email' AND place_of_birth='$placeOfBirth'");

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $firstName = mysqli_real_escape_string($db, $row['first_name']);
    $contactNumber = mysqli_real_escape_string($db, $row['id_number']);
    $password = mysqli_real_escape_string($db, sha1($idNumber)); // Hash the ID number as password

    $insertQuery = "INSERT INTO `users` (`username`, `contact_no`, `email`, `password`) 
                    VALUES ('$firstName', '$contactNumber', '$email', '$password')";

    if (mysqli_query($db, $insertQuery)) {
        // Insert successful
        $to = $email;
        $subject = 'Your Login Details';
        $message = "Hello $firstName,\n\nYour contact number is: $contactNumber\nYour password is: $idNumber\n\nPlease keep this information secure.";
        $headers = 'From: vykvincent@gmail.com';

        if (mail($to, $subject, $message, $headers)) {
            echo 'Inserted into users table and email sent'; 
        } else {
            echo 'Inserted into users table but email sending failed';
        }
    } else {
        echo 'Error: ' . mysqli_error($db); // Insert failed
    }
} else {
    echo 'User does not exist in the system'; // Data does not match
}
?>