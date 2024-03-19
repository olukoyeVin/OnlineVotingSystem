<?php
include("config.php"); // Include database connection

$idNumber = $_POST['id_number'];
$email = $_POST['email'];
$placeOfBirth = $_POST['place_of_birth'];

$result = mysqli_query($db, "SELECT * FROM `database` WHERE id_number='$idNumber' AND email='$email' AND place_of_birth='$placeOfBirth'");

if (!$result) {
    echo 'Error: ' . mysqli_error($db);
} else {
    if (mysqli_num_rows($result) > 0) {
        echo 'true'; // Data matches
    } else {
        echo 'false'; // Data does not match
    }
}
?>
