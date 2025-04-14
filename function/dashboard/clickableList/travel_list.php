<?php
include '../database/db_connect.php'; // Include database connection

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Query to fetch travel orders for the current month using indexno
$query = "
    SELECT e.indexno, e.employee_id, 
           CONCAT(e.lname, ', ', e.fname, ' ', COALESCE(e.extname, ''), ' ', COALESCE(e.midname, '')) AS full_name, 
           l.purpose, l.destination, l.dateapplied,
           l.startdate, l.enddate, l.specific_dates
    FROM travelorder l 
    JOIN employee e ON e.indexno = l.emp_index
    WHERE MONTH(l.dateapplied) = ? AND YEAR(l.dateapplied) = ?
    ORDER BY l.dateapplied ASC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $currentMonth, $currentYear);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<tr data-indexno='{$row['indexno']}'>";
    echo "<td>{$row['employee_id']}</td>";
    echo "<td>{$row['full_name']}</td>";
    echo "<td>{$row['purpose']}</td>";
    echo "<td>{$row['destination']}</td>";
    echo "<td>" . ($row['dateapplied'] ?? 'N/A') . "</td>";
    echo "<td>" . ($row['startdate'] ?? 'N/A') . "</td>";
    echo "<td>" . ($row['enddate'] ?? 'N/A') . "</td>";
    if (!empty($row['specific_dates'])) {
        $dates = preg_split('/[\n,]+/', $row['specific_dates']); // split by comma or newline
        echo "<td>";
        foreach ($dates as $date) {
            $date = trim($date);
            if (!empty($date)) {
                echo htmlspecialchars($date) . "<br>";
            }
        }
        echo "</td>";
    } else {
        echo "<td>N/A</td>";
    }
    
    
    echo "</tr>";
}
?>
