<?php
include '../database/db_connect.php'; // Include database connection

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Query to fetch leave applications for the current month using emp_index
$query = "
    SELECT e.employee_id, e.indexno, 
           CONCAT(e.lname, ', ', e.fname, ' ', COALESCE(e.extname, ''), ' ', COALESCE(e.midname, '')) AS full_name, 
           l.leavetype, l.dateapplied, l.startdate, l.enddate, l.numofdays 
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
    echo "<tr data-employee-id='{$row['employee_id']}'>"; // Store employee_id as a data attribute
    echo "<td>{$row['employee_id']}</td>";  // ✅ Now showing employee_id instead of indexno
    echo "<td>{$row['full_name']}</td>";
    echo "<td>{$row['leavetype']}</td>";
    echo "<td>{$row['dateapplied']}</td>";
    echo "<td>{$row['startdate']}</td>";
    echo "<td>{$row['enddate']}</td>";
    echo "<td>{$row['numofdays']}</td>";
    echo "</tr>";
}
?>
