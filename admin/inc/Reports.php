<?php
require_once 'config.php';
require_once 'inc/vendor/setasign/fpdf/fpdf.php'; // Include FPDF library

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['generate_pdf'])) {
        generatePdfReport();
    }
}

function generatePdfReport() {
    global $db;
    // Implement your logic to generate PDF report
    $query = "SELECT id_number, email, place_of_birth, contact_no FROM voter_application";
    $result = $db->query($query);

    // Create the 'reports' directory if it doesn't exist
    if (!file_exists('reports')) {
        mkdir('reports', 0777, true);
    }

    // Create a new PDF instance
    $pdf = new FPDF();
    $pdf->AddPage();

    // Header information
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Title: Voter application report', 0, 1, 'L');
    $pdf->Cell(0, 10, 'Author: Olukoye-system', 0, 1, 'L');
    $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d H:i:s'), 0, 1, 'L');
    $pdf->Ln(10); // Add some space

    // Add a line
    $pdf->SetLineWidth(0.5);
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(5); // Add some space

    // Add table headers
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'ID Number', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Email', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Place of Birth', 1, 0, 'C');
    $pdf->Cell(80, 10, 'Contact Number', 1, 1, 'C');

    // Add table rows
    $pdf->SetFont('Arial', '', 12);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['id_number'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['email'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['place_of_birth'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['contact_no'], 1, 1, 'C');
    }

    // "Where to sign" section 
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'signature: ______________________________________________________', 0, 1, 'L');
    $pdf->Cell(0, 10, 'Date of signing: ___________________________________________________', 0, 1, 'L');
    
    // Footer
    $pdf->SetY(260); // Adjust the Y position as needed
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(0, 10, 'This report is solely generated for the use by the Olukoye-system incase of any queries reach out', 0, 0, 'C');

    // Page numbers
    $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');

    // Output the PDF as a file
    $pdfFileName = 'reports/voter_application_report.pdf';
    $pdf->Output('F', $pdfFileName);

    // Open the PDF in a new tab using JavaScript
    echo "<script>
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '$pdfFileName';
            form.target = '_blank';
            document.body.appendChild(form);
            form.submit();
          </script>";
}

// Dashboard Information
$totalVotesQuery = "SELECT COUNT(*) AS totalVotes FROM votings";
$totalVotesResult = $db->query($totalVotesQuery);
$totalVotesRow = $totalVotesResult->fetch_assoc();
$totalVotes = $totalVotesRow['totalVotes'];

$candidateVotesQuery = "SELECT candidate_id, COUNT(*) AS votes FROM votings GROUP BY candidate_id";
$candidateVotesResult = $db->query($candidateVotesQuery);
$candidateVotes = [];
while ($row = $candidateVotesResult->fetch_assoc()) {
    $candidateVotes[$row['candidate_id']] = $row['votes'];
}

$candidateNamesQuery = "SELECT candidate_name FROM candidate_details";
$candidateNamesResult = $db->query($candidateNamesQuery);
$candidateNames = [];
while ($row = $candidateNamesResult->fetch_assoc()) {
    $candidateNames[] = $row['candidate_name'];
}

$electionsQuery = "SELECT COUNT(*) AS totalElections FROM elections";
$electionsResult = $db->query($electionsQuery);
$electionsRow = $electionsResult->fetch_assoc();
$totalElections = $electionsRow['totalElections'];

$activeElectionsQuery = "SELECT COUNT(*) AS activeElections FROM elections WHERE status = 'active'";
$activeElectionsResult = $db->query($activeElectionsQuery);
$activeElectionsRow = $activeElectionsResult->fetch_assoc();
$activeElections = $activeElectionsRow['activeElections'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reports</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    h1 {
        margin-bottom: 20px; /* Add space below the header */
    }

    button {
        display: inline-block;
        width: 45%; /* Set the width of each button to 45% */
        margin: 5px; /* Add margin around each button */
        padding: 15px; /* Increase padding for larger buttons */
        border: none;
        background-color: green; /* Set button color to green */
        color: white;
        cursor: pointer;
        border-radius: 5px;
        box-sizing: border-box; /* Include padding and border in the element's total width and height */
        font-size: 16px; /* Increase font size */
    }

    button:hover {
        background-color: darkgreen;
    }

    /* Clearfix for button rows */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    /* Set width for buttons container */
    .button-container {
        width: 100%;
    }

    /* Set width for buttons in each row */
    .button-row {
        width: 50%;
        float: left;
    }

    /* Set chart container styles */
    .chart-container {
        width: 45%;
        float: left;
        margin: 10px;
        padding: 10px;
        background-color: #f0f0f0; /* Light gray background */
        border-radius: 5px;
    }
</style>
</head>
<body>
<h1>Reports</h1>
<form method="post">
    <button type="submit" name="generate_pdf">Voter Application Report</button>
</form>

<!-- Display Dashboard Information -->
<div class="chart-container">
    <canvas id="votesChart" width="200" height="150"></canvas>
</div>
<div class="chart-container">
    <canvas id="electionsChart" width="200" height="150"></canvas>
</div>

<script>
    var ctx1 = document.getElementById('votesChart').getContext('2d');
    var votesChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: [<?php echo '"' . implode('", "', $candidateNames) . '"'; ?>],
            datasets: [{
                label: 'Votes',
                data: [<?php echo implode(',', $candidateVotes); ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: false // Disable aspect ratio scaling
        }
    });

    var ctx2 = document.getElementById('electionsChart').getContext('2d');
    var electionsChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Active Elections', 'Total Elections'],
            datasets: [{
                label: 'Elections',
                data: [<?php echo $activeElections; ?>, <?php echo $totalElections - $activeElections; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Disable aspect ratio scaling
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Elections Overview'
                }
            }
        }
    });
</script>

</body>
</html>