<?php
include '../database/db_connect.php'; // Database connection

// Query to count only ACTIVE employees
$result = $conn->query("SELECT COUNT(*) AS total FROM employee WHERE status = 'Active'");

$row = $result->fetch_assoc();
echo $row['total']; // Output only active employees count
?>
