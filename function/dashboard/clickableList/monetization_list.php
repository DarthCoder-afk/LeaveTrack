<?php
include '../database/db_connect.php';

// Helper to convert a date into readable text or show "N/A"
function toTextDate($date) {
    if (
        empty($date) || 
        $date === '0000-00-00' || 
        $date === '-0001-11-30' ||
        $date === '1970-01-01'
    ) {
        return 'N/A';
    }
    $ts = strtotime($date);
    return $ts ? date("F j, Y", $ts) : htmlspecialchars($date);
}

// Updated query: LEFT JOIN and fallback to 'Deleted Employee'
$query = "
    SELECT 
        l.employee_id, 
        COALESCE(CONCAT(e.lname, ', ', e.fname, ' ', COALESCE(e.extname, ''), ' ', COALESCE(e.midname, '')), 'Deleted Employee') AS full_name, 
        l.leavetype, 
        l.dateapplied, 
        l.startdate, 
        l.enddate, 
        l.specific_dates 
    FROM leaveapplication l 
    LEFT JOIN employee e ON e.indexno = l.emp_index
    WHERE l.leavetype = 'Monetization'
    ORDER BY l.dateapplied ASC
";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<tr data-employee-id='" . htmlspecialchars($row['employee_id']) . "'>";

    echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['leavetype']) . "</td>";

    echo "<td>" . toTextDate($row['dateapplied']) . "</td>";
    echo "<td>" . toTextDate($row['startdate']) . "</td>";
    echo "<td>" . toTextDate($row['enddate']) . "</td>";

    // Format specific_dates
    if (!empty($row['specific_dates'])) {
        $rawDates = preg_split('/[\n,]+/', $row['specific_dates']);
        $dateObjects = [];

        foreach ($rawDates as $dateStr) {
            $dateStr = trim($dateStr);
            $timestamp = strtotime($dateStr);
            if ($timestamp) {
                $dateObjects[] = $timestamp;
            }
        }

        sort($dateObjects);

        echo "<td>";
        foreach ($dateObjects as $ts) {
            echo date("F j, Y", $ts) . "<br>";
        }
        echo "</td>";
    } else {
        echo "<td>N/A</td>";
    }

    echo "</tr>";
}
?>
