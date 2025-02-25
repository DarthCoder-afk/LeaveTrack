<?php
include '../database/db_connect.php'; // Include your database connection

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Query to count leave applications for the current month
$query = "
    SELECT COUNT(*) AS leave_count 
    FROM leaveapplication 
    WHERE MONTH(dateapplied) = ? AND YEAR(dateapplied) = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $currentMonth, $currentYear);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo $row['leave_count']; // Output the count
?>
