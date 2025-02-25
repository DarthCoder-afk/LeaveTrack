<?php
include '../database/db_connect.php'; // Database connection

// Query to count the number of employees
$result = $conn->query("SELECT COUNT(*) AS total FROM employee");
$row = $result->fetch_assoc();
echo $row['total']; // Output the total count
?>
