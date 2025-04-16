<?php
include '../database/db_connect.php';

$currentMonth = date('m');
$currentYear = date('Y');

$query = "
    SELECT e.employee_id, 
           CONCAT(e.lname, ', ', e.fname, ' ', COALESCE(e.extname, ''), ' ', COALESCE(e.midname, '')) AS full_name, 
           l.leavetype, l.dateapplied, l.startdate, l.enddate, l.numofdays,
           l.date_type, l.specific_dates
    FROM leaveapplication l 
    JOIN employee e ON e.indexno = l.emp_index 
    WHERE MONTH(l.dateapplied) = ? AND YEAR(l.dateapplied) = ?
    ORDER BY l.dateapplied ASC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $currentMonth, $currentYear);
$stmt->execute();
$result = $stmt->get_result();

function formatDate($date) {
    if (!$date || $date === '0000-00-00') return 'N/A';
    return date('F j, Y', strtotime($date));
}

while ($row = $result->fetch_assoc()) {
    $start = formatDate($row['startdate']);
    $end = formatDate($row['enddate']);
    $applied = formatDate($row['dateapplied']);

    // Format specific dates individually
    $specific = 'N/A';
    if (!empty($row['specific_dates'])) {
        $specificDatesArray = array_filter(array_map('trim', explode(',', $row['specific_dates'])));
        if (count($specificDatesArray)) {
            $specific = implode("<br>", array_map('formatDate', $specificDatesArray));
        }
    }

    $numdays = $row['date_type'] === 'specific'
        ? count($specificDatesArray ?? [])
        : $row['numofdays'];

    echo "<tr data-employee-id='{$row['employee_id']}'>";
    echo "<td>{$row['employee_id']}</td>";
    echo "<td>{$row['full_name']}</td>";
    echo "<td>{$row['leavetype']}</td>";
    echo "<td>{$applied}</td>";
    echo "<td>{$start}</td>";
    echo "<td>{$end}</td>";
    echo "<td style='white-space: nowrap;'>{$specific}</td>";
    echo "<td>{$numdays}</td>";
    echo "</tr>";
}
?>
