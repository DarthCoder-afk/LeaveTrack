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


// Leave Report Title with Date Range
$pdf->SetFont('Times', 'B', 17);
$pdf->Ln(5);
$pdf->Cell(0, 8, 'LEAVE APPLICATIONS REPORT', 0, 1, 'C'); 
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 8, "Date Range: " . date("F d, Y", strtotime($start)) . " to " . date("F d, Y", strtotime($end)), 0, 1, 'C');
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
           CONCAT(e.lname, ',', ' ', e.fname, ' ', e.midname) AS fullname, 
           l.leavetype, l.startdate, l.enddate
    FROM leaveapplication l
    JOIN employee e ON l.employee_id = e.employee_id
    WHERE l.startdate BETWEEN ? AND ?
    ORDER BY l.startdate ASC
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
        $defaultHeight = 10; // Default row height
        $leaveTypeWidth = 45; // Leave Type column width
        $lineHeight = 5; // Line height for MultiCell
    
        // Calculate text height based on content
        $leaveTypeLines = ceil($pdf->GetStringWidth($row['leavetype']) / ($leaveTypeWidth - 2));
        $leaveTypeHeight = max($defaultHeight, $leaveTypeLines * $lineHeight);
    
        // Get current X, Y before writing
        $x = $pdf->GetX();
        $y = $pdf->GetY();
    
        // ID Column
        $pdf->Cell(20, $leaveTypeHeight, $row['employee_id'], 1, 0, 'C');
    
        // Full Name Column
        $pdf->Cell(70, $leaveTypeHeight, $row['fullname'], 1, 0, 'C');
    
        // Leave Type - Centered Text
        $leaveTypeX = $x + 90;
        $leaveTypeY = $y + ($leaveTypeHeight - ($leaveTypeLines * $lineHeight)) / 2; // Centering Formula
    
        $pdf->SetXY($leaveTypeX, $leaveTypeY); 
        $pdf->MultiCell($leaveTypeWidth, $lineHeight, $row['leavetype'], 0, 'C'); 
    
        // Manually draw Leave Type Border
        $pdf->Rect($leaveTypeX, $y, $leaveTypeWidth, $leaveTypeHeight);
    
        // Reset position for remaining columns
        $pdf->SetXY($x + 135, $y);
    
        // Start Date & End Date
        $pdf->Cell(30, $leaveTypeHeight, $row['startdate'], 1, 0, 'C');
        $pdf->Cell(30, $leaveTypeHeight, $row['enddate'], 1, 1, 'C');
    
        // Move Y position down properly
        $pdf->SetY($y + $leaveTypeHeight);
    }         
}

// Format the filename with start and end dates
$filename = 'LEAVE_APPLICATIONS_' . $start . '_to_' . $end . '.pdf';

// Output the PDF with the dynamic filename
$pdf->Output('D', $filename);


$stmt->close();
$conn->close();
?>
