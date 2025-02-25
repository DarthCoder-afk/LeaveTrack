<?php
include '../database/db_connect.php'; // Include database connection

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Query to fetch leave applications for the current month
$query = "
    SELECT e.employee_id, 
           CONCAT(e.lname, ', ', e.fname, ' ', e.extname, ' ', e.midname) AS full_name, 
           l.purpose, l.destination, l.dateapplied
    FROM travelorder l 
    JOIN employee e ON e.employee_id = l.employee_id 
    WHERE MONTH(l.dateapplied) = ? AND YEAR(l.dateapplied) = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $currentMonth, $currentYear);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['employee_id']}</td>";
    echo "<td>{$row['full_name']}</td>"; // Full name added
    echo "<td>{$row['purpose']}</td>";
    echo "<td>{$row['destination']}</td>";
    echo "<td>{$row['dateapplied']}</td>";
    echo "</tr>";
}
?>
