<?php
include '../database/db_connect.php'; // Include database connection

// Query to count Monetization leave applications
$query = "SELECT COUNT(*) AS total FROM leaveapplication WHERE leavetype = 'Monetization'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

echo $row['total']; // Output the count
?>
