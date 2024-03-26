<?php 
    require_once("inc/header.php");
    require_once("inc/navigation.php");

    if(isset($_GET['homepage']))
    {
        require_once("inc/homepage.php");
    }
    else if(isset($_GET['addElectionPage']))
    {
        require_once("inc/add_elections.php");
    }
    else if(isset($_GET['addCandidatePage']))
    {
        require_once("inc/add_candidates.php");
    }
    else if(isset($_GET['addVoterPage']))
    {
        require_once("inc/add_voter.php");
    }
    else if(isset($_GET['voterApplicationPage']))
    {
        require_once("inc/voter_application.php");
    }
    else if(isset($_GET['reportsPage']))
    {
        require_once("inc/Reports.php");
    }
    else if(isset($_GET['generateReportsPage']))
    {
        require_once("inc/generate_reports.php");
    }
    else if(isset($_GET['viewResult']))
    {
        require_once("inc/viewResults.php");
    }
    else if(isset($_GET['otp_verificationPage']))
    {
        require_once("inc/otp_verification.php");
    }
?>

<?php 
    require_once("inc/footer.php");
?>
