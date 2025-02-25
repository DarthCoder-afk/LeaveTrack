<?php
include '../database/db_connect.php'; // Include database connection

$currentYear = date('Y');
$currentMonth = date('m');

// Fetch travel orders for the current month
$query = "SELECT t.*, e.full_name FROM travelorder t 
          JOIN employees e ON t.employee_id = e.employee_id 
          WHERE YEAR(t.dateapplied) = ? AND MONTH(t.dateapplied) = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $currentYear, $currentMonth);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['employee_id']}</td>
            <td>{$row['full_name']}</td>
            <td>{$row['purpose']}</td>
            <td>{$row['destination']}</td>
            <td>{$row['dateapplied']}</td>
            <td>{$row['startdate']}</td>
            <td>{$row['enddate']}</td>
            <td>{$row['numofdays']}</td>
          </tr>";
}

$stmt->close();
$conn->close();
?>
