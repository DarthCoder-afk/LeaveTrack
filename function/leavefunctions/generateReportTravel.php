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
}

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
$pdf->Cell(0,8,'TRAVEL ORDER REPORT',0,1,'C');
$pdf->SetFont('Times','',12);
$pdf->Cell(0,8,"Date Range: " . date("F d, Y", strtotime($start)) . " to " . date("F d, Y", strtotime($end)),0,1,'C');
$pdf->Ln(8);

// Draw table header function
function drawTravelHeader($pdf) {
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(15,10,'ID',1,0,'C');
    $pdf->Cell(45,10,'Full Name',1,0,'C');
    $pdf->Cell(40,10,'Purpose',1,0,'C');
    $pdf->Cell(40,10,'Destination',1,0,'C');
    $pdf->Cell(60,10,'Date',1,1,'C');
    $pdf->SetFont('Arial','',12);
}

drawTravelHeader($pdf);

// Fetch data including specific_dates
$stmt = $conn->prepare("
    SELECT e.employee_id,
           CONCAT(e.lname,', ',e.fname,' ',e.midname) AS fullname,
           t.purpose,
           t.destination,
           t.startdate,
           t.enddate,
           t.specific_dates
      FROM travelorder t
      JOIN employee e ON t.employee_id = e.employee_id
     WHERE (t.startdate BETWEEN ? AND ?)
        OR (t.specific_dates IS NOT NULL AND t.specific_dates <> '')
     ORDER BY COALESCE(t.startdate,
                       STR_TO_DATE(SUBSTRING_INDEX(t.specific_dates, ',', 1), '%Y-%m-%d')
                      ) ASC
");

$stmt->bind_param('ss',$start,$end);
$stmt->execute();
$result = $stmt->get_result();

$lineHeight   = 5;
$bottomMargin = 20;

while ($row = $result->fetch_assoc()) {
    // Build dateRange from specific or start/end
    if (!empty($row['specific_dates'])) {
        $dlist = explode(',', $row['specific_dates']);
        $fmt   = array_map(fn($d)=>date('F j, Y',strtotime(trim($d))), $dlist);
        $dateRange = implode(', ', $fmt);
    } elseif (!empty($row['startdate']) && !empty($row['enddate'])) {
        $dateRange = date('F j, Y',strtotime($row['startdate']))
                   . ' to ' . date('F j, Y',strtotime($row['enddate']));
    } else {
        $dateRange = 'N/A';
    }

    // Current position
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Calculate heights
    $hId    = $pdf->GetMultiCellHeight(15, $lineHeight, $row['employee_id']);
    $hName  = $pdf->GetMultiCellHeight(45, $lineHeight, $row['fullname']);
    $hPurp  = $pdf->GetMultiCellHeight(40, $lineHeight, $row['purpose']);
    $hDest  = $pdf->GetMultiCellHeight(40, $lineHeight, $row['destination']);
    $hDate  = $pdf->GetMultiCellHeight(60, $lineHeight, $dateRange);
    $rowH   = max($hId, $hName, $hPurp, $hDest, $hDate);

    // Page break
    if ($y + $rowH > $pdf->GetPageHeight() - $bottomMargin) {
        $pdf->AddPage();
        drawTravelHeader($pdf);
        $y = $pdf->GetY();
    }

    // Draw cells
    $pdf->SetXY($x, $y);  $pdf->MultiCell(15, $lineHeight, $row['employee_id'], 1, 'C');
    $pdf->SetXY($x+15, $y); $pdf->MultiCell(45, $lineHeight, utf8_decode($row['fullname']), 1, 'C');
    $pdf->SetXY($x+60, $y); $pdf->MultiCell(40, $lineHeight, $row['purpose'],      1, 'C');
    $pdf->SetXY($x+100,$y); $pdf->MultiCell(40, $lineHeight, $row['destination'],  1, 'C');
    $pdf->SetXY($x+140,$y); $pdf->MultiCell(60, $lineHeight, $dateRange,          1, 'C');

    // Advance to next row
    $pdf->SetY($y + $rowH);
}

// Output
$pdf->Output('D', 'TRAVEL_ORDERS_' . $start . '_to_' . $end . '.pdf');
$stmt->close();
$conn->close();
?>