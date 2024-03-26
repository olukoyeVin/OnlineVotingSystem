<?php 
    if(isset($_GET['added'])) {
?>
        <div class="alert alert-success my-3" role="alert">
            User has been added successfully.
        </div>
<?php 
    } else if(isset($_GET['failed'])) {
?>
        <div class="alert alert-danger my-3" role="alert">
            User adding failed, please try again.
        </div>
<?php
    } else if (isset($_GET['delete_id'])) {
        $d_id = $_GET['delete_id'];
        mysqli_query($db, "DELETE FROM users WHERE id = $d_id") or die(mysqli_error($db));
?>
        <div class="alert alert-danger my-3" role="alert">
            User has been deleted successfully!
        </div>
<?php
    }
?>

<div class="row my-3">
<div class="col-4">
    <h3>Add New User</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username" class="form-control" required />
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" class="form-control" required />
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Email" class="form-control" required />
        </div>
        <div class="form-group">
            <input type="text" name="contact_no" placeholder="Contact Number" class="form-control" required />
        </div>
        <div class="form-group">
            <input type="file" name="user_photo" class="form-control" required />
        </div>
        <input type="submit" value="Add User" name="addUserBtn" class="btn btn-success" />
    </form>
</div>   

    <div class="col-8">
        <h3>User Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Photo</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Action </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $fetchingData = mysqli_query($db, "SELECT * FROM users") or die(mysqli_error($db)); 
                    $isAnyUserAdded = mysqli_num_rows($fetchingData);

                    if($isAnyUserAdded > 0) {
                        $sno = 1;
                        while($row = mysqli_fetch_assoc($fetchingData)) {
                            
                ?>
                            <tr>
                                <style>
                                    .user_photo {
                                        width: 70px; /* Set the width of the circular image */
                                        height: 70px; /* Set the height of the circular image */
                                        object-fit: cover; /* Prevent the image from stretching */
                                        border-radius: 50%; /* Make the image circular */
                                    }
                                </style>
                                <td><?php echo $sno++; ?></td>
                                <td><img src="<?php echo $row['user_photo']; ?>" class="user_photo" /></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['contact_no']; ?></td>
                                <td> 
                                    <a href="#" class="btn btn-sm btn-warning"> Edit </a>
                                    <button class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $row['id']; ?>)"> Delete </button>
                                </td>
                            </tr>   
                <?php
                        }
                    } else {
                ?>
                        <tr> 
                            <td colspan="5"> No any user is added yet. </td>
                        </tr>
                <?php
                    }
                ?>
            </tbody>    
        </table>
    </div>
</div>
<script>
    const DeleteData = (id) => {
        let c = confirm("Are you sure you really want to delete this user?");

        if (c == true) {
            location.assign(`index.php?addVoterPage=1&delete_id=${id}`);
        }
    };
</script>

<?php 
    if(isset($_POST['addUserBtn'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $contact_no = mysqli_real_escape_string($db, $_POST['contact_no']);
        $email = mysqli_real_escape_string($db, $_POST['email']); // Add this line to get the email
        $password = mysqli_real_escape_string($db, sha1($_POST['password']));
        $user_role = "Voter"; 

        // Photograph Logic Starts
        $targetted_folder = "../assets/images/user_photos/";
        $user_photo = $targetted_folder . rand(111111111, 99999999999) . "_" . rand(111111111, 99999999999) . $_FILES['user_photo']['name'];
        $user_photo_tmp_name = $_FILES['user_photo']['tmp_name'];
        $user_photo_type = strtolower(pathinfo($user_photo, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "png", "jpeg");        
        $image_size = $_FILES['user_photo']['size'];

        if($image_size < 2000000) // 2 MB
        {
            if(in_array($user_photo_type, $allowed_types))
            {
                if(move_uploaded_file($user_photo_tmp_name, $user_photo))
                {
                    // inserting into db
                    mysqli_query($db, "INSERT INTO users(username, email, contact_no, password, user_photo) VALUES('". $username ."', '". $email ."', '". $contact_no ."', '". $password ."', '". $user_photo ."')") or die(mysqli_error($db));

                    echo "<script> location.assign('index.php?addVoterPage=1&added=1'); </script>";
                } else {
                    echo "<script> location.assign('index.php?addVoterPage=1&failed=1'); </script>";                    
                }
            } else {
                echo "<script> location.assign('index.php?addVoterPage=1&invalidFile=1'); </script>";
            }
        } else {
            echo "<script> location.assign('index.php?addVoterPage=1&largeFile=1'); </script>";
        }
        // Photograph Logic Ends
    }
?>

