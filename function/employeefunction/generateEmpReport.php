<?php
require('../../libraries/fpdf.php');
require('../../database/db_connect.php');

if (!isset($_GET['start']) || !isset($_GET['end']) || !isset($_GET['employee_id'])) {
    die("Error: Missing required parameters.");
}

$start = $_GET['start'];
$end = $_GET['end'];
$employee_id = $_GET['employee_id'];

class PDF extends FPDF {
    public function Header() {
        global $municipality, $province, $logoPath;

        $this->Image($logoPath, 15, 10, 25);
        $this->SetFont('Times', '', 12);
        $this->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
        $this->Cell(0, 5, 'Province of ' . $province, 0, 1, 'C');
        $this->Cell(0, 5, 'Municipality of ' . $municipality, 0, 1, 'C');
        $this->Ln(4);
        $this->SetFont('Times', 'B', 15);
        $this->Cell(0, 8, 'LEAVE APPLICATIONS REPORT', 0, 1, 'C');
        $this->SetFont('Times', '', 12);
        $this->Cell(0, 8, 'Date Range: ' . date("F d, Y", strtotime($_GET['start'])) . ' to ' . date("F d, Y", strtotime($_GET['end'])), 0, 1, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(220, 220, 220);
        $this->Cell(10, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(60, 10, 'Full Name', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Leave Type', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Date of Filing', 1, 0, 'C', true);
        $this->Cell(55, 10, 'Date', 1, 1, 'C', true);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    public function drawMultiRow($data, $widths, $lineHeight) {
        $nb = 0;
        foreach ($data as $i => $txt) {
            $nb = max($nb, $this->NbLines($widths[$i], $txt));
        }
        $h = $lineHeight * $nb;

        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage();
        }

        $x = $this->GetX();
        $y = $this->GetY();

        for ($i = 0; $i < count($data); $i++) {
            $w = $widths[$i];
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, $lineHeight, $data[$i], 0, 'L');
            $x += $w;
            $this->SetXY($x, $y);
        }

        $this->Ln($h);
    }

    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") $nb--;
        $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") { $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue; }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else $i = $sep + 1;
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else $i++;
        }
        return $nl;
    }
}

// Fetch settings
$settingsQuery = "SELECT municipality_name, province_name, logo_path FROM settings LIMIT 1";
$settingsResult = $conn->query($settingsQuery);
$settings = $settingsResult->fetch_assoc() ?: [];

$municipality = $settings['municipality_name'] ?? 'MUNICIPALITY OF TALISAY';
$province     = $settings['province_name'] ?? 'Camarines Norte';
$logoPath     = $settings['logo_path']     ?? '../../img/tali.png';

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);
$lineHeight = 6;

// Query leave applications
$stmt = $conn->prepare("
    SELECT e.employee_id,
           CONCAT(e.lname, ', ', e.fname, ' ', e.midname) AS fullname,
           e.lname, e.fname,
           l.leavetype, l.startdate, l.enddate, l.specific_dates, l.dateapplied
    FROM leaveapplication l
    JOIN employee e ON l.employee_id = e.employee_id
    WHERE l.dateapplied BETWEEN ? AND ? AND l.employee_id = ?
    ORDER BY l.dateapplied ASC
");

$stmt->bind_param("sss", $start, $end, $employee_id);
$stmt->execute();
$result = $stmt->get_result();

$fullnameForFilename = 'EMPLOYEE';

if ($result->num_rows === 0) {
    $pdf->Cell(190, 10, 'No leave records found for the selected date range.', 1, 1, 'C');
} else {
    $firstRow = $result->fetch_assoc();
    $fullnameForFilename = preg_replace('/[^a-zA-Z0-9]/', '_', $firstRow['lname'] . '_' . $firstRow['fname']);
    $result->data_seek(0); // Reset

    while ($row = $result->fetch_assoc()) {
        $dateRange = 'N/A';

        if (!empty($row['startdate']) && !empty($row['enddate'])) {
            $dateRange = date("F j, Y", strtotime($row['startdate'])) . " to " . date("F j, Y", strtotime($row['enddate']));
        } elseif (!empty($row['specific_dates'])) {
            $dates = preg_split('/[\n,]+/', $row['specific_dates']);
            $cleanDates = [];

            foreach ($dates as $date) {
                $ts = strtotime(trim($date));
                if ($ts) $cleanDates[] = $ts;
            }

            sort($cleanDates);
            $formatted = array_map(fn($ts) => date("F j, Y", $ts), $cleanDates);
            $dateRange = implode(", ", $formatted);
        }

        $data = [
            $row['employee_id'],
            utf8_decode($row['fullname']),
            $row['leavetype'],
            date("F j, Y", strtotime($row['dateapplied'])),
            $dateRange
        ];
        $widths = [10, 60, 30, 35, 55];

        $pdf->drawMultiRow($data, $widths, $lineHeight);
    }
}

$filename = 'LEAVE_APPLICATIONS_' . $fullnameForFilename . '_' . $start . '_to_' . $end . '.pdf';
$pdf->Output('D', $filename);
$stmt->close();
$conn->close();
?>
