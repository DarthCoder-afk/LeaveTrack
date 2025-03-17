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
$pdf->Cell(0, 8, '        LEAVE APPLICATIONS REPORT', 0, 1, 'C');
$pdf->Ln(8);

// Table Headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'ID', 1, 0, 'C');
$pdf->Cell(70, 10, 'Full Name', 1, 0, 'C');
$pdf->Cell(45, 10, 'Leave Type', 1, 0, 'C');
$pdf->Cell(30, 10, 'Start Date', 1, 0, 'C');
$pdf->Cell(30, 10, 'End Date', 1, 1, 'C');

// Fetch data
$stmt = $conn->prepare("
    SELECT e.employee_id, 
           CONCAT(e.fname, ' ', e.midname, ' ', e.lname) AS fullname, 
           l.leavetype, l.startdate, l.enddate
    FROM leaveapplication l
    JOIN employee e ON l.employee_id = e.employee_id
    WHERE l.startdate >= ? AND l.enddate <= ?
");

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("ss", $start, $end);
$stmt->execute();
$result = $stmt->get_result();

$pdf->SetFont('Arial', '', 12);

if ($result->num_rows == 0) {
    $pdf->Cell(195, 10, 'No records found for the selected date range.', 1, 1, 'C');
} else {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(20, 10, $row['employee_id'], 1, 0, 'C');
        $pdf->Cell(70, 10, $row['fullname'], 1, 0, 'C');
        $pdf->Cell(45, 10, $row['leavetype'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['startdate'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['enddate'], 1, 1, 'C');
    }
}

$pdf->Output('D', 'LEAVE_APPLICATIONS.pdf');

$stmt->close();
$conn->close();
?>
