<?php
include '../database/db_connect.php'; // Include database connection

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
    echo "<tr data-indexno='{$row['indexno']}'>";

    echo "<td>{$row['employee_id']}</td>";
    echo "<td>{$row['full_name']}</td>";
    echo "<td>{$row['leavetype']}</td>";
    echo "<td>" . ($row['dateapplied'] ?? 'N/A') . "</td>";
    echo "<td>" . ($row['startdate'] ?? 'N/A') . "</td>";
    echo "<td>" . ($row['enddate'] ?? 'N/A') . "</td>";

    // Format and display specific_dates vertically or show N/A
    if (!empty($row['specific_dates'])) {
        $dates = preg_split('/[\n,]+/', $row['specific_dates']); // split by comma or newline
        echo "<td>";
        foreach ($dates as $date) {
            $date = trim($date);
            if (!empty($date)) {
                echo htmlspecialchars($date) . "<br>";
            }
        }
        echo "</td>";
    } else {
        echo "<td>N/A</td>";
    }

    echo "</tr>";
}
?>
