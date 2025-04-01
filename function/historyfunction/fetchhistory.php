<?php
    include '../database/db_connect.php';
    date_default_timezone_set('Asia/Manila');
    $result = $conn->query("SELECT * FROM activity_log");
   
    while ($row = $result->fetch_assoc()) {
        $datetime = "{$row['activity_date']} {$row['activity_time']}";
        $formatted_emp_id = str_pad($row['emp_id'], 3, "0", STR_PAD_LEFT);
        echo "<tr class='text-center'>";
        echo "<td>{$formatted_emp_id}</td>";
        echo "<td>{$row['activity_type']}</td>";
        echo "<td>{$row['activity_details']}</td>";
        echo "<td>{$datetime}</td>";
        echo "</tr>";
    } 

?>

