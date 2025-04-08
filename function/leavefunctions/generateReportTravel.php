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
$logoWidth = 30; 
$pdf->Image('../../img/tali.png', 15, 10, $logoWidth); 

// Set font for header
$pdf->SetFont('Times', '', 12);
$pageWidth = $pdf->GetPageWidth();
$headerX = ($pageWidth / 2) - ($logoWidth / 2) - 10; 

$pdf->SetXY($headerX, 15);
$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'L');

$pdf->SetXY($headerX, 20);
$pdf->Cell(0, 5, 'Province of ' . $provinceName, 0, 1, 'L');

$pdf->SetXY($headerX, 25);
$pdf->Cell(0, 5, 'Municipality of ' . $municipalityName, 0, 1, 'L');


// Travel Order Report Title
$pdf->SetFont('Times', 'B', 17);
$pdf->Ln(5);
$pdf->Cell(0, 8, 'TRAVEL ORDER REPORT', 0, 1, 'C'); 
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 8, "Date Range: " . date("F d, Y", strtotime($start)) . " to " . date("F d, Y", strtotime($end)), 0, 1, 'C');
$pdf->Ln(8);

// Table Headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 10, 'ID', 1, 0, 'C');
$pdf->Cell(45, 10, 'Full Name', 1, 0, 'C');
$pdf->Cell(40, 10, 'Purpose', 1, 0, 'C');
$pdf->Cell(40, 10, 'Destination', 1, 0, 'C');
$pdf->Cell(25, 10, 'Start Date', 1, 0, 'C');
$pdf->Cell(25, 10, 'End Date', 1, 1, 'C');

// Fetch data
$stmt = $conn->prepare("
    SELECT e.employee_id, 
           CONCAT(e.lname, ',', ' ', e.fname, ' ', e.midname) AS fullname, 
           l.purpose, l.destination, l.startdate, l.enddate
    FROM travelorder l
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
    $pdf->Cell(200, 10, 'No records found for the selected date range.', 1, 1, 'C');
} else {
    while ($row = $result->fetch_assoc()) {
        $columnWidth = [15, 45, 40, 40, 25, 25]; // Column widths
        $lineHeight = 5; // Line height
    
        // Calculate line count for Full Name, Purpose, and Destination
        $fullnameLines = ceil($pdf->GetStringWidth($row['fullname']) / ($columnWidth[1] - 2));
        $purposeLines = ceil($pdf->GetStringWidth($row['purpose']) / ($columnWidth[2] - 2));
        $destinationLines = ceil($pdf->GetStringWidth($row['destination']) / ($columnWidth[3] - 2));
    
        // Get the maximum lines needed for the row
        $maxLines = max(1, $fullnameLines, $purposeLines, $destinationLines);
        $rowHeight = max(10, $maxLines * $lineHeight);
    
        // Store current X, Y position
        $x = $pdf->GetX();
        $y = $pdf->GetY();
    
        // ID Column
        $pdf->Cell($columnWidth[0], $rowHeight, $row['employee_id'], 1, 0, 'C');
    
        // Full Name Column (MultiCell)
        $pdf->SetXY($x + $columnWidth[0], $y);
        $pdf->MultiCell($columnWidth[1], $lineHeight, $row['fullname'], 0, 'C');
        $pdf->Rect($x + $columnWidth[0], $y, $columnWidth[1], $rowHeight);
    
        // Purpose Column (MultiCell)
        $pdf->SetXY($x + $columnWidth[0] + $columnWidth[1], $y);
        $pdf->MultiCell($columnWidth[2], $lineHeight, $row['purpose'], 0, 'C');
        $pdf->Rect($x + $columnWidth[0] + $columnWidth[1], $y, $columnWidth[2], $rowHeight);
    
        // Destination Column (MultiCell) - Fix applied here
        $pdf->SetXY($x + $columnWidth[0] + $columnWidth[1] + $columnWidth[2], $y);
        $pdf->MultiCell($columnWidth[3], $lineHeight, $row['destination'], 0, 'C');
        $pdf->Rect($x + $columnWidth[0] + $columnWidth[1] + $columnWidth[2], $y, $columnWidth[3], $rowHeight);
    
        // Move cursor back to correct position for next columns
        $pdf->SetXY($x + $columnWidth[0] + $columnWidth[1] + $columnWidth[2] + $columnWidth[3], $y);
    
        // Start Date Column
        $pdf->Cell($columnWidth[4], $rowHeight, $row['startdate'], 1, 0, 'C');
    
        // End Date Column
        $pdf->Cell($columnWidth[5], $rowHeight, $row['enddate'], 1, 1, 'C');
    
        // Move to next row
        $pdf->SetY($y + $rowHeight);
    }
    
}

// Generate the file name
$filename = 'TRAVEL_ORDERS_' . $start . '_to_' . $end . '.pdf';

// Output the PDF
$pdf->Output('D', $filename);

$stmt->close();
$conn->close();
?>
