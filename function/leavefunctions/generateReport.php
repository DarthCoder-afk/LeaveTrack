<?php
require('../../libraries/fpdf.php');
require('../../database/db_connect.php');

// Check if generating all reports or date-specific reports
$generateAll = isset($_GET['all']) && $_GET['all'] === 'true';

if (!$generateAll && (!isset($_GET['start']) || !isset($_GET['end']))) {
    die("Error: Start and end dates are required unless generating all reports.");
}

// Set dates if not generating all reports
if (!$generateAll) {
    $start = $_GET['start'];
    $end = $_GET['end'];
}

// Extend FPDF to add line-count and height helpers
class PDF extends FPDF {
    // Calculate number of lines a MultiCell will use
    public function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb-1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    // Calculate the height of a MultiCell
    public function GetMultiCellHeight($w, $lineHeight, $txt) {
        return $this->NbLines($w, $txt) * $lineHeight;
    }
    
    // Add footer with page number
    function Footer() {
        // Set position 15 mm from bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
    }
}

// Initialize PDF
$pdf = new PDF();
$pdf->AliasNbPages(); // <- Important for total page count
$pdf->AddPage();

// Fetch settings
$settingsQuery  = "SELECT municipality_name, province_name, logo_path FROM settings LIMIT 1";
$settingsResult = $conn->query($settingsQuery);
$settings       = $settingsResult->fetch_assoc() ?: [];

$municipality = !empty($settings['municipality_name']) ? $settings['municipality_name'] : 'MUNICIPALITY OF TALISAY';
$province     = !empty($settings['province_name'])     ? $settings['province_name']     : 'Camarines Norte';
$logoPath     = !empty($settings['logo_path'])         ? $settings['logo_path']         : '../../img/tali.png';

// Header: logo on left, titles centered
$logoWidth = 25;
$logoX = 15;
$logoY = 10;
$pdf->Image($logoPath, $logoX, $logoY, $logoWidth);

// Set font
$pdf->SetFont('Times', '', 12);
$pdf->SetXY(0, 12); // move to top
$pdf->Cell(0, 5, '         Republic of the Philippines', 0, 1, 'C');
$pdf->Cell(0, 5, 'Province of ' . $province, 0, 1, 'C');
$pdf->Cell(0, 5, 'Municipality of ' . $municipality, 0, 1, 'C');

// Title
$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 17);
$pdf->Cell(0, 8, 'LEAVE APPLICATIONS REPORT', 0, 1, 'C');
$pdf->SetFont('Times', '', 12);

// Display appropriate subtitle based on report type
if ($generateAll) {
    $pdf->Cell(0, 8, "All Leave Applications", 0, 1, 'C');
} else {
    $pdf->Cell(0, 8, "Date Range: " . date("F d, Y", strtotime($start)) . " to " . date("F d, Y", strtotime($end)), 0, 1, 'C');
}

$pdf->Ln(5);

// Function to draw table headers
function drawTableHeader($pdf) {
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,10,'ID',1,0,'C');
    $pdf->Cell(60,10,'Full Name',1,0,'C');
    $pdf->Cell(30,10,'Leave Type',1,0,'C');
    $pdf->Cell(35,10,'Date of Filing',1,0,'C'); // Moved up
    $pdf->Cell(50,10,'Date',1,1,'C');
    $pdf->SetFont('Arial','',11);
}

drawTableHeader($pdf);

// Prepare query based on report type
if ($generateAll) {
    // Query for all leave applications
    $sql = "SELECT e.employee_id,
           CONCAT(e.lname, ',', ' ', e.fname, ' ', e.midname) AS fullname,
           l.leavetype, l.startdate, l.enddate, l.specific_dates, l.dateapplied
    FROM leaveapplication l
    JOIN employee e ON l.employee_id = e.employee_id
    ORDER BY l.dateapplied ASC";
    
    $result = $conn->query($sql);
} else {
    // Filtered query for specific date range
    $stmt = $conn->prepare("
    SELECT e.employee_id,
           CONCAT(e.lname, ',', ' ', e.fname, ' ', e.midname) AS fullname,
           l.leavetype, l.startdate, l.enddate, l.specific_dates, l.dateapplied
    FROM leaveapplication l
    JOIN employee e ON l.employee_id = e.employee_id
    WHERE l.dateapplied BETWEEN ? AND ?
    ORDER BY l.dateapplied ASC
    ");
    
    if (!$stmt) die("SQL Error: " . $conn->error);
    $stmt->bind_param("ss", $start, $end);
    $stmt->execute();
    $result = $stmt->get_result();
}

$pdf->SetFont('Arial','',11);
$lineHeight = 5;
$bottomMargin = 20;

if ($result->num_rows === 0) {
    $pdf->Cell(195,10,'No records found.',1,1,'C');
} else {
    while ($row = $result->fetch_assoc()) {
        // Build human-readable dateRange
        if (!empty($row['startdate']) && !empty($row['enddate'])) {
            $dateRange = date("F j, Y", strtotime($row['startdate']))
                       . " to " . date("F j, Y", strtotime($row['enddate']));
        } elseif (!empty($row['specific_dates'])) {
            $dates = preg_split('/[\n,]+/', $row['specific_dates']); // Split by newline or comma
            $cleanDates = [];
            
            foreach ($dates as $date) {
                $trimmed = trim($date);
                $ts = strtotime($trimmed);
                if ($ts) {
                    $cleanDates[] = $ts;
                }
            }
            
            sort($cleanDates); // Sort timestamps ascending
            
            $formatted = array_map(fn($ts) => date("F j, Y", $ts), $cleanDates);
            $dateRange = implode(", ", $formatted);
            
        } else {
            $dateRange = 'No Record';
        }

        // Handle the date of filing - FIX for empty date values
        $dateOfFiling = !empty($row['dateapplied']) && $row['dateapplied'] != '0000-00-00' ? 
            date("F j, Y", strtotime($row['dateapplied'])) : 'No Record';

        // Current position
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Compute each cell's height
        $hId     = $pdf->GetMultiCellHeight(20, $lineHeight, $row['employee_id']);
        $hName   = $pdf->GetMultiCellHeight(60, $lineHeight, $row['fullname']);
        $hType   = $pdf->GetMultiCellHeight(30, $lineHeight, $row['leavetype']);
        $hApp    = $pdf->GetMultiCellHeight(35, $lineHeight, $dateOfFiling);
        $hDate   = $pdf->GetMultiCellHeight(50, $lineHeight, $dateRange);
        $rowH    = max($hId, $hName, $hType, $hApp, $hDate);

        // Page break check
        if ($y + $rowH > $pdf->GetPageHeight() - $bottomMargin) {
            $pdf->AddPage();
            drawTableHeader($pdf);
            $y = $pdf->GetY();
        }

        // Draw borders
        $pdf->Rect($x,      $y, 20, $rowH);  // ID
        $pdf->Rect($x+20,   $y, 60, $rowH);  // Full Name
        $pdf->Rect($x+80,   $y, 30, $rowH);  // Leave Type
        $pdf->Rect($x+110,  $y, 35, $rowH);  // Date of Filing
        $pdf->Rect($x+145,  $y, 50, $rowH);  // Date
        
        // Draw content
        $pdf->SetXY($x,      $y); $pdf->MultiCell(20, $lineHeight, $row['employee_id'], 0, 'C');
        $pdf->SetXY($x+20,   $y); $pdf->MultiCell(60, $lineHeight, utf8_decode($row['fullname']), 0, 'C');
        $pdf->SetXY($x+80,   $y); $pdf->MultiCell(30, $lineHeight, $row['leavetype'], 0, 'C');
        $pdf->SetXY($x+110,  $y); $pdf->MultiCell(35, $lineHeight, $dateOfFiling, 0, 'C');
        $pdf->SetXY($x+145,  $y); $pdf->MultiCell(50, $lineHeight, $dateRange, 0, 'C');

        // Move to next row
        $pdf->SetY($y + $rowH);
    }
}

// Output file
if ($generateAll) {
    $filename = 'ALL_LEAVE_APPLICATIONS_REPORT.pdf';
} else {
    $filename = 'LEAVE_APPLICATIONS_' . $start . '_to_' . $end . '.pdf';
}

$pdf->Output('D', $filename);

// Close database connection
if (isset($stmt)) $stmt->close();
$conn->close();
?>