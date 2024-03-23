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
    $query = "SELECT id_number, first_name, last_name, email FROM voter_application";
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
    $pdf->Cell(40, 10, 'First Name', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Last Name', 1, 0, 'C');
    $pdf->Cell(80, 10, 'Email', 1, 1, 'C');

    // Add table rows
    $pdf->SetFont('Arial', '', 12);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['id_number'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['first_name'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['last_name'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['email'], 1, 1, 'C');
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reports</title>
</head>
<body>
<h1>Reports</h1>
<form method="post">
    <button type="submit" name="generate_pdf">Generate PDF Report</button>
</form>
</body>
</html>
