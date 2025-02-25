<?php
include '../database/db_connect.php'; // Include database connection

// Get the current year and month
$currentYear = date('Y');
$currentMonth = date('m');

// Query to count leave applications submitted this month
$query = "SELECT COUNT(*) AS total FROM travelorder WHERE YEAR(dateapplied) = ? AND MONTH(dateapplied) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $currentYear, $currentMonth);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo $row['total']; // Output the count
?>
