<?php
require('../../libraries/fpdf.php'); 
require('../../database/db_connect.php'); 

if (!isset($_GET['start']) || !isset($_GET['end'])) {
    die("Error: Start and end dates are required.");
}

$start = $_GET['start'];
$end = $_GET['end'];

$pdf = new FPDF();
$pdf->AddPage();

// Logo - Adjusted position
$logoWidth = 30; // Width of the logo
$pdf->Image('../../img/tali.png', 15, 10, $logoWidth); // X=15, Y=10, Width=30

// Set font for header
$pdf->SetFont('Times', '', 12);

// Calculate center position manually
$pageWidth = $pdf->GetPageWidth();
$headerX = ($pageWidth / 2) - ($logoWidth / 2) - 10; // Shift to the left slightly

$pdf->SetXY($headerX, 15);
$pdf->Cell(0, 5, '    Republic of the Philippines', 0, 1, 'L');

$pdf->SetXY($headerX, 20);
$pdf->Cell(0, 5, '   Province of Camarines Norte', 0, 1, 'L');

$pdf->SetXY($headerX, 25);
$pdf->Cell(0, 5, 'MUNICIPALITY OF TALISAY', 0, 1, 'L');

// Leave Report Title
$pdf->SetFont('Times', 'B', 12);
$pdf->Ln(5);
$pdf->Cell(0, 8, '        TRAVEL ORDERS REPORT', 0, 1, 'C');
$pdf->Ln(8);

// Table Headers (Adjusted width to fit the page properly)
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 10, 'ID', 1, 0, 'C'); // Reduced from 20 to 15
$pdf->Cell(55, 10, 'Full Name', 1, 0, 'C'); // Reduced from 70 to 55
$pdf->Cell(40, 10, 'Purpose', 1, 0, 'C'); // Adjusted from 45 to 40
$pdf->Cell(40, 10, 'Destination', 1, 0, 'C'); // Adjusted from 45 to 40
$pdf->Cell(25, 10, 'Start Date', 1, 0, 'C'); // Adjusted from 30 to 25
$pdf->Cell(25, 10, 'End Date', 1, 1, 'C'); // Adjusted from 30 to 25

// Fetch data
$stmt = $conn->prepare("
    SELECT e.employee_id, 
           CONCAT(e.lname, ',', ' ', e.fname, ' ', e.midname) AS fullname, 
           l.purpose, l.destination, l.startdate, l.enddate
    FROM travelorder l
    JOIN employee e ON l.employee_id = e.employee_id
    WHERE l.startdate >= ? AND l.enddate <= ?
    ORDER BY l.startdate ASC
");


if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("ss", $start, $end);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data
$pdf->SetFont('Arial', '', 12);
if ($result->num_rows == 0) {
    $pdf->Cell(200, 10, 'No records found for the selected date range.', 1, 1, 'C');
} else {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(15, 10, $row['employee_id'], 1, 0, 'C');
        $pdf->Cell(55, 10, $row['fullname'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['purpose'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['destination'], 1, 0, 'C');
        $pdf->Cell(25, 10, $row['startdate'], 1, 0, 'C');
        $pdf->Cell(25, 10, $row['enddate'], 1, 1, 'C');
    }
}
// Format the filename with start and end dates
$filename = '   TRAVEL_ORDERS_' . $start . '_to_' . $end . '.pdf';

// Output the PDF with the dynamic filename
$pdf->Output('D', $filename);


$stmt->close();
$conn->close();
?>
