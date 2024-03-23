<!DOCTYPE html>
<html>
<head>
    <title>Applicant Details</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="col-8">
            <h3>Applicant Details</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID Number</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Place of Birth</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include("config.php");
                    $fetchingData = mysqli_query($db, "SELECT * FROM voter_application") or die(mysqli_error($db)); 
                    $isAnyUserAdded = mysqli_num_rows($fetchingData);

                    if($isAnyUserAdded > 0) {
                        $sno = 1;
                        while($row = mysqli_fetch_assoc($fetchingData)) {
                            ?>          
                            <tr>
                                <td><?php echo $row['id_number']; ?></td>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['contact_no']; ?></td>
                                <td><?php echo $row['place_of_birth']; ?></td>
                                <td>
                                    <button class="btn btn-success" onclick="compareData('<?php echo $row['id_number']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['place_of_birth']; ?>')">Approve</button>
                                </td>
                            </tr>   
                            <?php
                        }
                    } else {
                        ?>
                        <tr> 
                            <td colspan="7"> No any user is added yet. </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>    
            </table>
        </div>
    </div>

    <script>
        function compareData(idNumber, email, placeOfBirth) {
            $.ajax({
                url: "inc/compare.php", // PHP script for comparison
                type: 'POST',
                data: { id_number: idNumber, email: email, place_of_birth: placeOfBirth },
                success: function(response) {
                    alert(response); // Display the result (true/false)
                },
                error: function() {
                    alert('Error occurred while comparing data');
                }
            });
        }

    </script>


</body>
</html>
