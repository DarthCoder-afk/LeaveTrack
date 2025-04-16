<?php
include '../database/db_connect.php'; // Include database connection

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

// Query to fetch Monetization applications with employee full name using indexno
$query = "
    SELECT e.indexno, e.employee_id, 
           CONCAT(e.lname, ', ', e.fname, ' ', COALESCE(e.extname, ''), ' ', COALESCE(e.midname, '')) AS full_name, 
           l.leavetype, l.dateapplied, l.startdate, l.enddate, l.specific_dates 
    FROM leaveapplication l 
    JOIN employee e ON e.indexno = l.emp_index
    WHERE l.leavetype = 'Monetization'
    ORDER BY l.dateapplied ASC
";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<tr data-indexno='" . htmlspecialchars($row['indexno']) . "'>";

    echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['leavetype']) . "</td>";

    // Format individual date fields
    echo "<td>" . toTextDate($row['dateapplied']) . "</td>";
    echo "<td>" . toTextDate($row['startdate']) . "</td>";
    echo "<td>" . toTextDate($row['enddate']) . "</td>";

    // Format specific_dates (line by line)
    if (!empty($row['specific_dates'])) {
        $dates = preg_split('/[\n,]+/', $row['specific_dates']);
        echo "<td>";
        foreach ($dates as $date) {
            $date = trim($date);
            if (!empty($date)) {
                echo toTextDate($date) . "<br>";
            }
        }
        echo "</td>";
    } else {
        echo "<td>N/A</td>";
    }

    echo "</tr>";
}
?>
