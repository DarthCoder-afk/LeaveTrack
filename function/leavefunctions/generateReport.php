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

// Fetch dynamic municipality name and logo path
$settingsQuery = "SELECT municipality_name, province_name, logo_path FROM settings LIMIT 1";
$settingsResult = $conn->query($settingsQuery);
$settings = $settingsResult->fetch_assoc();

// Set defaults if settings are not available or empty
$municipalityName = isset($settings['municipality_name']) && !empty($settings['municipality_name']) 
    ? $settings['municipality_name'] 
    : 'MUNICIPALITY OF TALISAY';

$provinceName = isset($settings['province_name']) && !empty($settings['province_name']) 
    ? $settings['province_name'] 
    : 'Camarines Norte';

$logoPath = isset($settings['logo_path']) && !empty($settings['logo_path']) 
    ? $settings['logo_path'] 
    : '../../img/tali.png';  // Ensure this file exists!

// Logo - Adjusted position
$logoWidth = 30; // Width of the logo
$pdf->Image($logoPath, 15, 10, $logoWidth); // X=15, Y=10, Width=30

// Set font for header
$pdf->SetFont('Times', '', 12);

// Calculate center position manually
$pageWidth = $pdf->GetPageWidth();
$headerX = ($pageWidth / 2) - ($logoWidth / 2) - 10; // Shift to the left slightly

$pdf->SetXY($headerX, 15);
$pdf->Cell(0, 5, '    Republic of the Philippines', 0, 1, 'L');

$pdf->SetXY($headerX, 20);
$pdf->Cell(0, 5, '  Province of ' . $provinceName, 0, 1, 'L');

$pdf->SetXY($headerX, 25);
$pdf->Cell(0, 5, '        Municipality of ' . $municipalityName, 0, 1, 'L');

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
        $defaultHeight = 10;
        $leaveTypeWidth = 45;
        $lineHeight = 5;

        $leaveTypeLines = ceil($pdf->GetStringWidth($row['leavetype']) / ($leaveTypeWidth - 2));
        $leaveTypeHeight = max($defaultHeight, $leaveTypeLines * $lineHeight);

        $x = $pdf->GetX();
        $y = $pdf->GetY();

        $pdf->Cell(20, $leaveTypeHeight, $row['employee_id'], 1, 0, 'C');
        $pdf->Cell(70, $leaveTypeHeight, $row['fullname'], 1, 0, 'C');

        $leaveTypeX = $x + 90;
        $leaveTypeY = $y + ($leaveTypeHeight - ($leaveTypeLines * $lineHeight)) / 2;

        $pdf->SetXY($leaveTypeX, $leaveTypeY);
        $pdf->MultiCell($leaveTypeWidth, $lineHeight, $row['leavetype'], 0, 'C');

        $pdf->Rect($leaveTypeX, $y, $leaveTypeWidth, $leaveTypeHeight);

        $pdf->SetXY($x + 135, $y);
        $pdf->Cell(30, $leaveTypeHeight, $row['startdate'], 1, 0, 'C');
        $pdf->Cell(30, $leaveTypeHeight, $row['enddate'], 1, 1, 'C');

        $pdf->SetY($y + $leaveTypeHeight);
    }         
}

// Filename formatting
$filename = 'LEAVE_APPLICATIONS_' . $start . '_to_' . $end . '.pdf';
$pdf->Output('D', $filename);

$stmt->close();
$conn->close();
?>
