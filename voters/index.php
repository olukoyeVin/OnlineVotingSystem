<?php 
    require_once("inc/header.php");
    require_once("inc/navigation.php");
?>
<?php 
    if(isset($_GET['user_id']))
    {
        $d_id = $_GET['user_id'];
?>
       <div class="alert alert-danger my-3" role="alert">
            Election has been cast successfully!
        </div>
<?php

    }
?>
<div class="row my-3">
    <div class="col-12">
        <h3> Voters Panel </h3>

        <?php 
            $fetchingActiveElections = mysqli_query($db, "SELECT * FROM elections WHERE status = 'Active'") or die(mysqli_error($db));
            $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

            if($totalActiveElections > 0) 
            {
                while($data = mysqli_fetch_assoc($fetchingActiveElections))
                {
                    $election_id = $data['id'];
                    $election_topic = $data['election_topic'];    
            ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="4" class="bg-green text-white"><h5> ELECTION TOPIC: <?php echo strtoupper($election_topic); ?></h5></th>
                            </tr>
                            <tr>
                                <th> Photo </th>
                                <th> Candidate Details </th>
                                <th> # of Votes </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $fetchingCandidates = mysqli_query($db, "SELECT * FROM candidate_details WHERE election_id = '". $election_id ."'") or die(mysqli_error($db));

                            while($candidateData = mysqli_fetch_assoc($fetchingCandidates))
                            {
                                $candidate_id = $candidateData['id'];
                                $candidate_photo = $candidateData['candidate_photo'];

                                // Fetching Candidate Votes 
                                $fetchingVotes = mysqli_query($db, "SELECT * FROM votings WHERE candidate_id = '". $candidate_id . "'") or die(mysqli_error($db));
                                $totalVotes = mysqli_num_rows($fetchingVotes);

                        ?>
                                <tr>
                                    <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo"> </td>
                                    <td><?php echo "<b>" . $candidateData['candidate_name'] . "</b><br />" . $candidateData['candidate_details']; ?></td>
                                    <td><?php echo $totalVotes; ?></td>
                                    <td>
                                <?php
                                        $checkIfVoteCasted = mysqli_query($db, "SELECT * FROM votings WHERE voters_id = '". $_SESSION['user_id'] ."' AND election_id = '". $election_id ."'") or die(mysqli_error($db));    
                                        $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);

                                        if($isVoteCasted > 0)
                                        {
                                            $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                                            $voteCastedToCandidate = $voteCastedData['candidate_id'];

                                            if($voteCastedToCandidate == $candidate_id)
                                            {
                                ?>

                                                <img src="../assets/images/vote.png" width="100px;">
                                <?php
                                            }
                                        }else {
                                ?>
                                            <button class="btn btn-md btn-success" onclick="confirmVote(<?php echo $election_id; ?>, <?php echo $candidate_id; ?>, <?php echo $_SESSION['user_id']; ?>)"> Vote </button>
                                <?php
                                        }

                                        
                                ?>
                            
                                </td>
                                </tr>
                                <script>
                                    const confirmVote = (election_id, candidate_id, voters_id) => 
                                    {
                                        let c = confirm("Are you sure you really want to vote?");

                                        if(c == true)
                                        {
                                            CastVote(election_id, candidate_id, voters_id);
                                        }
                                    }

                                    const CastVote = (election_id, candidate_id, voters_id) => 
                                    {
                                        $.ajax({
                                            type: "POST", 
                                            url: "inc/ajaxCalls.php",
                                            data: "e_id=" + election_id + "&c_id=" + candidate_id + "&v_id=" + voters_id, 
                                            success: function(response) {
                                                
                                                if(response == "Success")
                                                {
                                                    location.assign("index.php?voteCasted=1");
                                                }else {
                                                    location.assign("index.php?voteNotCasted=1");
                                                }
                                            }
                                        });
                                    }

                                </script>
                        <?php
                            }
                        ?>
                        </tbody>

                    </table>
            <?php
                
                }
            }else {
                 // Personalized message for voters if no active elections found
                 $name = $_SESSION['username']; 
                 echo "<p>Dear $name,</p>";
                 echo "<p>Your participation in the upcoming election is crucial for shaping the future of our community/country. While you wait for the election day, remember that every vote counts and contributes to the collective voice of our society.</p>";
                 echo "<p>Use this time to learn about the candidates, their policies, and the issues that matter most to you. Discuss and share your thoughts with friends and family to encourage informed decisions. Stay engaged with reliable news sources to stay informed about developments leading up to the election.</p>";
                 echo "<p>Remember, democracy thrives when citizens actively participate. Your vote is your voice—make it count!</p>";
                 echo "<p>Thank you for being an active and responsible citizen.</p>";
                 echo "<p>Sincerely,<br>Olukoye System</p>";
            }
        ?>

        
    </div>
</div>


<?php
    require_once("inc/footer.php");
?>
