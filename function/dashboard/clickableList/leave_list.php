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

while ($row = $result->fetch_assoc()) {
    $start = !empty($row['startdate']) ? $row['startdate'] : 'N/A';
    $end = !empty($row['enddate']) ? $row['enddate'] : 'N/A';
    $specific = !empty($row['specific_dates']) ? str_replace(",", "<br>", $row['specific_dates']) : 'N/A';
    $numdays = $row['date_type'] === 'specific'
                ? count(array_filter(explode(',', $row['specific_dates'])))
                : $row['numofdays'];

    echo "<tr data-employee-id='{$row['employee_id']}'>";
    echo "<td>{$row['employee_id']}</td>";
    echo "<td>{$row['full_name']}</td>";
    echo "<td>{$row['leavetype']}</td>";
    echo "<td>{$row['dateapplied']}</td>";
    echo "<td>$start</td>";
    echo "<td>$end</td>";
    echo "<td style='white-space: nowrap;'>$specific</td>";
    echo "<td>$numdays</td>";
    echo "</tr>";
}
?>
