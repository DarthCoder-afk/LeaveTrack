<?php
include '../database/db_connect.php'; // Include database connection

// Query to fetch Monetization applications with employee full name using indexno
$query = "
    SELECT e.indexno, e.employee_id, 
           CONCAT(e.lname, ', ', e.fname, ' ', COALESCE(e.extname, ''), ' ', COALESCE(e.midname, '')) AS full_name, 
           l.leavetype, l.dateapplied, l.startdate, l.enddate, l.numofdays 
    FROM leaveapplication l 
    JOIN employee e ON e.indexno = l.emp_index  -- ✅ Use indexno instead of employee_id
    WHERE l.leavetype = 'Monetization'
    ORDER BY l.dateapplied DESC
";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<tr data-indexno='{$row['indexno']}'>"; // ✅ Store indexno as a data attribute

    echo "<td>{$row['employee_id']}</td>"; // ✅ Display employee_id (can repeat)
    echo "<td>{$row['full_name']}</td>";
    echo "<td>{$row['leavetype']}</td>";
    echo "<td>{$row['dateapplied']}</td>";
    echo "</tr>";
}
?>
