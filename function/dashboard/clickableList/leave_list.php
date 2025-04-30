<?php
include '../database/db_connect.php';

$currentMonth = date('m');
$currentYear = date('Y');

$query = "
    SELECT 
        l.employee_id, 
        COALESCE(CONCAT(e.lname, ', ', e.fname, ' ', COALESCE(e.extname, ''), ' ', COALESCE(e.midname, '')), 'Deleted Employee') AS full_name, 
        l.leavetype, 
        l.dateapplied, 
        l.startdate, 
        l.enddate, 
        l.numofdays,
        l.date_type, 
        l.specific_dates
    FROM leaveapplication l 
    LEFT JOIN employee e ON e.indexno = l.emp_index 
    WHERE MONTH(l.dateapplied) = ? AND YEAR(l.dateapplied) = ?
    ORDER BY l.dateapplied ASC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $currentMonth, $currentYear);
$stmt->execute();
$result = $stmt->get_result();

// Format date into "Month Day, Year"
function formatDate($date) {
    if (!$date || $date === '0000-00-00') return 'N/A';
    return date('F j, Y', strtotime($date));
}

// Format number of days (e.g., 3.5 -> "3 days and half day")
function formatNumberOfDays($days) {
    $num = round(floatval($days), 2);
    $wholeDays = floor($num);
    $fraction = $num - $wholeDays;

    if ($num === 0.5) {
        return 'Half day';
    } elseif ($fraction == 0.5) {
        return $wholeDays . ' days and half day';
    } else {
        return $wholeDays . ($wholeDays === 1 ? ' day' : ' days');
    }
}

while ($row = $result->fetch_assoc()) {
    $start = formatDate($row['startdate']);
    $end = formatDate($row['enddate']);
    $applied = formatDate($row['dateapplied']);

    // Format specific dates
    $specific = 'N/A';
    if (!empty($row['specific_dates'])) {
        $specificDatesArray = array_filter(array_map('trim', preg_split('/[\n,;]+/', $row['specific_dates'])));
        $dateObjects = array_filter(array_map(function ($dateStr) {
            $timestamp = strtotime($dateStr);
            return $timestamp ? new DateTime($dateStr) : null;
        }, $specificDatesArray));
        usort($dateObjects, function ($a, $b) {
            return $a <=> $b;
        });
        if (count($dateObjects)) {
            $specific = implode("<br>", array_map(function ($dateObj) {
                return $dateObj->format('F j, Y');
            }, $dateObjects));
        }
    }

    $rawDays = is_numeric($row['numofdays']) ? floatval($row['numofdays']) : (
        isset($specificDatesArray) ? count($specificDatesArray) : 0
    );

    $formattedDays = formatNumberOfDays($rawDays);

    echo "<tr data-employee-id='{$row['employee_id']}'>";
    echo "<td>{$row['employee_id']}</td>";
    echo "<td>{$row['full_name']}</td>";
    echo "<td>{$row['leavetype']}</td>";
    echo "<td>{$applied}</td>";
    echo "<td>{$start}</td>";
    echo "<td>{$end}</td>";
    echo "<td style='white-space: nowrap;'>{$specific}</td>";
    echo "<td>{$formattedDays}</td>";
    echo "</tr>";
}
?>
