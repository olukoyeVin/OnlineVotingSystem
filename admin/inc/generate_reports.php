<?php
require_once 'config.php';

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
    $query = "SELECT * FROM votes";
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

// Generate reports based on the requested type
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'doc':
            generateDocReport();
            break;
        case 'pdf':
            generatePdfReport();
            break;
        default:
            // Invalid report type
            header("HTTP/1.0 404 Not Found");
            echo "Invalid report type.";
    }
}
?>
