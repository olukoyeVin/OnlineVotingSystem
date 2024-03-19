<?php
require_once 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['generate_doc'])) {
        generateDocReport();
    } elseif (isset($_POST['generate_pdf'])) {
        generatePdfReport();
    }
}

function generateDocReport() {
    global $db;
    // Implement your logic to generate DOC report
    $query = "SELECT * FROM voter_application";
    $result = $db->query($query);

    // Example using PHPWord
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    
    while ($row = $result->fetch_assoc()) {
        $section->addText("Name: {$row['first_name']} {$row['last_name']}");
        $section->addText("Email: {$row['email']}");
        $section->addText("---------------------");
    }
    
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('reports/report.docx');
}

function generatePdfReport() {
    global $db;
    // Implement your logic to generate PDF report
    $query = "SELECT * FROM votings";
    $result = $db->query($query);

    // Example using TCPDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(0, 10, "Candidate: {$row['candidate']} - Votes: {$row['votes']}");
        $pdf->Ln();
    }
    $pdf->Output('reports/report.pdf', 'F');
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
    <button type="submit" name="generate_doc">Generate DOC Report</button>
    <button type="submit" name="generate_pdf">Generate PDF Report</button>
</form>
</body>
</html>
