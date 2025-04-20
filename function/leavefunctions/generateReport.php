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
$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'L');

$pdf->SetXY($headerX, 20);
$pdf->Cell(0, 5, 'Province of ' . $provinceName, 0, 1, 'L');

$pdf->SetXY($headerX, 25);
$pdf->Cell(0, 5, 'Municipality of ' . $municipalityName, 0, 1, 'L');

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
$pdf->Cell(60, 10, 'Date', 1, 1, 'C'); // Merged "Date" column

// Fetch data
$stmt = $conn->prepare("
    SELECT e.employee_id, 
           CONCAT(e.lname, ',', ' ', e.fname, ' ', e.midname) AS fullname, 
           l.leavetype, l.startdate, l.enddate, l.specific_dates, l.dateapplied
    FROM leaveapplication l
    JOIN employee e ON l.employee_id = e.employee_id
    WHERE l.dateapplied BETWEEN ? AND ?
    ORDER BY l.dateapplied ASC
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
        $lineHeight = 5;
        $defaultHeight = 10;
    
        $id = $row['employee_id'];
        $fullname = $row['fullname'];
        $leavetype = $row['leavetype'];
    
        if (!empty($row['startdate']) && !empty($row['enddate'])) {
            $dateRange = date("F j, Y", strtotime($row['startdate'])) . " to " . date("F j, Y", strtotime($row['enddate']));
        } elseif (!empty($row['specific_dates'])) {
            $dates = explode(',', $row['specific_dates']);
            $formattedDates = array_map(function ($date) {
                return date("F j, Y", strtotime(trim($date)));
            }, $dates);
            $dateRange = implode(", ", $formattedDates);
        } else {
            $dateRange = "N/A";
        }
    
        $colWidths = [20, 70, 45, 60];
        $leaveTypeLines = ceil($pdf->GetStringWidth($leavetype) / ($colWidths[2] - 2));
        $dateLines = ceil($pdf->GetStringWidth($dateRange) / ($colWidths[3] - 2));
        $maxLines = max(1, $leaveTypeLines, $dateLines);
        $rowHeight = $maxLines * $lineHeight;
    
        // Check if we need a new page
        if ($pdf->GetY() + $rowHeight > $pdf->GetPageHeight() - 20) {
            $pdf->AddPage();
    
            // Redraw table headers on new page
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(20, 10, 'ID', 1, 0, 'C');
            $pdf->Cell(70, 10, 'Full Name', 1, 0, 'C');
            $pdf->Cell(45, 10, 'Leave Type', 1, 0, 'C');
            $pdf->Cell(60, 10, 'Date', 1, 1, 'C');
            $pdf->SetFont('Arial', '', 12);
        }
    
        $x = $pdf->GetX();
        $y = $pdf->GetY();
    
        // ID
        $pdf->SetXY($x, $y);
        $pdf->MultiCell($colWidths[0], $lineHeight, $id, 1, 'C');
    
        // Full Name
        $pdf->SetXY($x + $colWidths[0], $y);
        $pdf->MultiCell($colWidths[1], $lineHeight, $fullname, 1, 'C');
    
        // Leave Type
        $pdf->SetXY($x + $colWidths[0] + $colWidths[1], $y);
        $pdf->MultiCell($colWidths[2], $lineHeight, $leavetype, 1, 'C');
    
        // Date
        $pdf->SetXY($x + $colWidths[0] + $colWidths[1] + $colWidths[2], $y);
        $pdf->MultiCell($colWidths[3], $lineHeight, $dateRange, 1, 'C');
    
        // Move to next row
        $pdf->SetY($y + $rowHeight);
    }
    

}


// Filename formatting
$filename = 'LEAVE_APPLICATIONS_' . $start . '_to_' . $end . '.pdf';
$pdf->Output('D', $filename);

$stmt->close();
$conn->close();
?>
