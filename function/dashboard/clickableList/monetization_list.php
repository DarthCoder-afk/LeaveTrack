<?php
include '../database/db_connect.php'; // Include database connection

// Query to fetch Monetization applications with employee full name
$query = "
    SELECT e.employee_id, 
           CONCAT(e.lname, ', ', e.fname, ' ', e.extname, ' ', e.midname) AS full_name, 
           l.leavetype, l.dateapplied, l.startdate, l.enddate, l.numofdays 
    FROM leaveapplication l 
    JOIN employee e ON e.employee_id = l.employee_id 
    WHERE l.leavetype = 'Monetization'
";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['employee_id']}</td>";
    echo "<td>{$row['full_name']}</td>"; // Full name added here
    echo "<td>{$row['leavetype']}</td>";
    echo "<td>{$row['dateapplied']}</td>";
    echo "</tr>";
}
?>
