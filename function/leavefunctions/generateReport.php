<?php
require('../../libraries/fpdf.php');
require('../../database/db_connect.php');

if (!isset($_GET['start']) || !isset($_GET['end'])) {
    die("Error: Start and end dates are required.");
}

$start = $_GET['start'];
$end   = $_GET['end'];

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
}

// Initialize PDF
$pdf = new PDF();
$pdf->AddPage();

// Fetch settings
$settingsQuery  = "SELECT municipality_name, province_name, logo_path FROM settings LIMIT 1";
$settingsResult = $conn->query($settingsQuery);
$settings       = $settingsResult->fetch_assoc() ?: [];

$municipality = !empty($settings['municipality_name']) ? $settings['municipality_name'] : 'MUNICIPALITY OF TALISAY';
$province     = !empty($settings['province_name'])     ? $settings['province_name']     : 'Camarines Norte';
$logoPath     = !empty($settings['logo_path'])         ? $settings['logo_path']         : '../../img/tali.png';

// Header: logo + titles
$logoWidth = 30;
$pdf->Image($logoPath, 15, 10, $logoWidth);
$pdf->SetFont('Times','',12);
$pageWidth = $pdf->GetPageWidth();
$headerX   = ($pageWidth/2) - ($logoWidth/2) - 10;

$pdf->SetXY($headerX,15);
$pdf->Cell(0,5,'Republic of the Philippines',0,1,'L');
$pdf->SetXY($headerX,20);
$pdf->Cell(0,5,'Province of ' . $province,0,1,'L');
$pdf->SetXY($headerX,25);
$pdf->Cell(0,5,'Municipality of ' . $municipality,0,1,'L');

// Title
$pdf->SetFont('Times','B',17);
$pdf->Ln(5);
$pdf->Cell(0,8,'LEAVE APPLICATIONS REPORT',0,1,'C');
$pdf->SetFont('Times','',12);
$pdf->Cell(0,8,"Date Range: " . date("F d, Y", strtotime($start)) . " to " . date("F d, Y", strtotime($end)),0,1,'C');
$pdf->Ln(8);

// Function to draw table headers
function drawTableHeader($pdf) {
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,10,'ID',1,0,'C');
    $pdf->Cell(70,10,'Full Name',1,0,'C');
    $pdf->Cell(45,10,'Leave Type',1,0,'C');
    $pdf->Cell(60,10,'Date',1,1,'C');
    $pdf->SetFont('Arial','',12);
}

drawTableHeader($pdf);

// Prepare query filtering by dateapplied
$stmt = $conn->prepare("\n    SELECT e.employee_id,\n           CONCAT(e.lname, ',', ' ', e.fname, ' ', e.midname) AS fullname,\n           l.leavetype, l.startdate, l.enddate, l.specific_dates, l.dateapplied\n    FROM leaveapplication l\n    JOIN employee e ON l.employee_id = e.employee_id\n    WHERE l.dateapplied BETWEEN ? AND ?\n    ORDER BY l.dateapplied ASC\n");
if (!$stmt) die("SQL Error: " . $conn->error);
$stmt->bind_param("ss", $start, $end);
$stmt->execute();
$result = $stmt->get_result();

$pdf->SetFont('Arial','',12);
$lineHeight = 5;
$bottomMargin = 20;

if ($result->num_rows === 0) {
    $pdf->Cell(195,10,'No records found for the selected date range.',1,1,'C');
} else {
    while ($row = $result->fetch_assoc()) {
        // Build human-readable dateRange
        if (!empty($row['startdate']) && !empty($row['enddate'])) {
            $dateRange = date("F j, Y", strtotime($row['startdate']))
                       . " to " . date("F j, Y", strtotime($row['enddate']));
        } elseif (!empty($row['specific_dates'])) {
            $dates = explode(',', $row['specific_dates']);
            $formatted = array_map(fn($d) => date("F j, Y", strtotime(trim($d))), $dates);
            $dateRange = implode(", ", $formatted);
        } else {
            $dateRange = 'N/A';
        }

        // Current position
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Compute each cell's height
        $hId   = $pdf->GetMultiCellHeight(20, $lineHeight, $row['employee_id']);
        $hName = $pdf->GetMultiCellHeight(70, $lineHeight, $row['fullname']);
        $hType = $pdf->GetMultiCellHeight(45, $lineHeight, $row['leavetype']);
        $hDate = $pdf->GetMultiCellHeight(60, $lineHeight, $dateRange);
        $rowH  = max($hId, $hName, $hType, $hDate);

        // Page break check
        if ($y + $rowH > $pdf->GetPageHeight() - $bottomMargin) {
            $pdf->AddPage();
            drawTableHeader($pdf);
            $y = $pdf->GetY();
        }

        // Draw each cell aligned at Y=$y
        $pdf->SetXY($x,      $y); $pdf->MultiCell(20, $lineHeight, $row['employee_id'], 1, 'C');
        $pdf->SetXY($x+20,   $y); $pdf->MultiCell(70, $lineHeight, utf8_decode($row['fullname']), 1, 'C');
        $pdf->SetXY($x+90,   $y); $pdf->MultiCell(45, $lineHeight, $row['leavetype'],      1, 'C');
        $pdf->SetXY($x+135,  $y); $pdf->MultiCell(60, $lineHeight, $dateRange,            1, 'C');

        // Move to next row
        $pdf->SetY($y + $rowH);
    }
}

// Output file
$filename = 'LEAVE_APPLICATIONS_' . $start . '_to_' . $end . '.pdf';
$pdf->Output('D', $filename);
$stmt->close();
$conn->close();
?>
