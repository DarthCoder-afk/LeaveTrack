<?php
require('../../libraries/fpdf.php');
require('../../database/db_connect.php');

// Check if "all reports" option is selected
$fetchAll = isset($_GET['all']) && $_GET['all'] == '1';

// Only require dates if not fetching all reports
if (!$fetchAll && (!isset($_GET['start']) || !isset($_GET['end']))) {
    die("Error: Start and end dates are required.");
}

// Set default values for start and end dates if fetching all reports
$start = $fetchAll ? '' : $_GET['start'];
$end = $fetchAll ? '' : $_GET['end'];

// Extend FPDF to add line-count and height helpers
class PDF extends FPDF {
    public function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb-1] == "\n") $nb--;
        $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") { $i++; $sep=-1; $j=$i; $l=0; $nl++; continue; }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) { if ($i == $j) $i++; }
                else $i = $sep+1;
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else { $i++; }
        }
        return $nl;
    }

    public function GetMultiCellHeight($w, $lineHeight, $txt) {
        return $this->NbLines($w, $txt) * $lineHeight;
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Fetch settings
$settingsQuery = "SELECT municipality_name, province_name, logo_path FROM settings LIMIT 1";
$settingsResult = $conn->query($settingsQuery);
$settings = $settingsResult->fetch_assoc() ?: [];

$municipality = !empty($settings['municipality_name']) ? $settings['municipality_name'] : 'MUNICIPALITY OF TALISAY';
$province = !empty($settings['province_name']) ? $settings['province_name'] : 'Camarines Norte';
$logoPath = !empty($settings['logo_path']) ? $settings['logo_path'] : '../../img/tali.png';

// Header
$logoWidth = 25;
$logoX = 15;
$logoY = 10;
$pdf->Image($logoPath, $logoX, $logoY, $logoWidth);

$pdf->SetFont('Times', '', 12);
$pdf->SetXY(0, 12);
$pdf->Cell(0, 5, '         Republic of the Philippines', 0, 1, 'C');
$pdf->Cell(0, 5, 'Province of ' . $province, 0, 1, 'C');
$pdf->Cell(0, 5, 'Municipality of ' . $municipality, 0, 1, 'C');

// Title
$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 17);
$pdf->Cell(0, 8, 'TRAVEL ORDER REPORT', 0, 1, 'C');
$pdf->SetFont('Times', '', 12);

if (!$fetchAll) {
    $pdf->Cell(0, 8, "Date Range: " . date("F d, Y", strtotime($start)) . " to " . date("F d, Y", strtotime($end)), 0, 1, 'C');
} else {
    $pdf->Cell(0, 8, "All Travel Orders", 0, 1, 'C');
}
$pdf->Ln(8);

// Draw table header
function drawTravelHeader($pdf) {
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(15,10,'ID',1,0,'C');
    $pdf->Cell(40,10,'Full Name',1,0,'C');
    $pdf->Cell(35,10,'Purpose',1,0,'C');
    $pdf->Cell(35,10,'Destination',1,0,'C');
    $pdf->Cell(30,10,'Date of Filing',1,0,'C'); // New column for Date Applied
    $pdf->Cell(35,10,'Travel Date',1,1,'C'); // Renamed from "Date" to "Travel Date"
    $pdf->SetFont('Arial','',12);
}

drawTravelHeader($pdf);

// Prepare SQL
if ($fetchAll) {
    $query = "
        SELECT e.employee_id,
               CONCAT(e.lname,', ',e.fname,' ',e.midname) AS fullname,
               t.purpose,
               t.destination,
               t.dateapplied,
               t.startdate,
               t.enddate,
               t.specific_dates
          FROM travelorder t
          JOIN employee e ON t.emp_index = e.indexno
         ORDER BY t.dateapplied DESC
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
} else {
    $query = "
        SELECT e.employee_id,
               CONCAT(e.lname,', ',e.fname,' ',e.midname) AS fullname,
               t.purpose,
               t.destination,
               t.dateapplied,
               t.startdate,
               t.enddate,
               t.specific_dates
          FROM travelorder t
          JOIN employee e ON t.emp_index = e.indexno
         WHERE t.dateapplied BETWEEN ? AND ?
         ORDER BY t.dateapplied DESC
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $start, $end);
    $stmt->execute();
}

$result = $stmt->get_result();

$lineHeight = 5;
$bottomMargin = 20;

while ($row = $result->fetch_assoc()) {
    if (!empty($row['specific_dates']) && $row['specific_dates'] != '0000-00-00') {
        $rawDates = preg_split('/[\n,]+/', $row['specific_dates']);
        $cleanedDates = [];
        foreach ($rawDates as $date) {
            $trimmed = trim($date);
            $ts = strtotime($trimmed);
            if ($ts !== false && $ts > 0) {
                $cleanedDates[] = $ts;
            }
        }
        if (count($cleanedDates) > 0) {
            sort($cleanedDates);
            $formattedDates = array_map(fn($ts) => date('F j, Y', $ts), $cleanedDates);
            $dateRange = implode(', ', $formattedDates);
        } else {
            $dateRange = 'No Record';
        }
    } elseif (!empty($row['startdate']) && !empty($row['enddate']) &&
              $row['startdate'] != '0000-00-00' && $row['enddate'] != '0000-00-00' &&
              strtotime($row['startdate']) > 0 && strtotime($row['enddate']) > 0) {
        $dateRange = date('F j, Y', strtotime($row['startdate']))
                   . ' to ' . date('F j, Y', strtotime($row['enddate']));
    } else {
        $dateRange = 'No Record';
    }
    
    // Format date_applied
    $dateApplied = !empty($row['dateapplied']) && $row['dateapplied'] != '0000-00-00' 
                 ? date('F j, Y', strtotime($row['dateapplied'])) 
                 : 'No Record';

    $x = $pdf->GetX();
    $y = $pdf->GetY();

    $hId     = $pdf->GetMultiCellHeight(15, $lineHeight, $row['employee_id']);
    $hName   = $pdf->GetMultiCellHeight(40, $lineHeight, $row['fullname']);
    $hPurp   = $pdf->GetMultiCellHeight(35, $lineHeight, $row['purpose']);
    $hDest   = $pdf->GetMultiCellHeight(35, $lineHeight, $row['destination']);
    $hDateAp = $pdf->GetMultiCellHeight(30, $lineHeight, $dateApplied);
    $hDate   = $pdf->GetMultiCellHeight(35, $lineHeight, $dateRange);
    $rowH    = max($hId, $hName, $hPurp, $hDest, $hDateAp, $hDate);

    if ($y + $rowH > $pdf->GetPageHeight() - $bottomMargin) {
        $pdf->AddPage();
        drawTravelHeader($pdf);
        $y = $pdf->GetY();
    }

    $pdf->Rect($x,      $y, 15, $rowH);
    $pdf->Rect($x+15,   $y, 40, $rowH);
    $pdf->Rect($x+55,   $y, 35, $rowH);
    $pdf->Rect($x+90,   $y, 35, $rowH);
    $pdf->Rect($x+125,  $y, 30, $rowH);
    $pdf->Rect($x+155,  $y, 35, $rowH);

    $pdf->SetXY($x,      $y); $pdf->MultiCell(15, $lineHeight, $row['employee_id'], 0, 'C');
    $pdf->SetXY($x+15,   $y); $pdf->MultiCell(40, $lineHeight, utf8_decode($row['fullname']), 0, 'C');
    $pdf->SetXY($x+55,   $y); $pdf->MultiCell(35, $lineHeight, $row['purpose'] ?: 'No Record', 0, 'C');
    $pdf->SetXY($x+90,   $y); $pdf->MultiCell(35, $lineHeight, $row['destination'] ?: 'No Record', 0, 'C');
    $pdf->SetXY($x+125,  $y); $pdf->MultiCell(30, $lineHeight, $dateApplied, 0, 'C');
    $pdf->SetXY($x+155,  $y); $pdf->MultiCell(35, $lineHeight, $dateRange, 0, 'C');

    $pdf->SetY($y + $rowH);
}

if ($result->num_rows == 0) {
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 20, 'No Travel Orders Found', 0, 1, 'C');
}

if ($fetchAll) {
    $filename = 'ALL_TRAVEL_ORDERS.pdf';
} else {
    $filename = 'TRAVEL_ORDERS_' . $start . '_to_' . $end . '.pdf';
}

$pdf->Output('D', $filename);
$stmt->close();
$conn->close();
?>