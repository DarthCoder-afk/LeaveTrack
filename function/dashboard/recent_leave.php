<?php
    include '../database/db_connect.php';
    $result = $conn->query("SELECT * FROM employee, leaveapplication WHERE employee.employee_id = leaveapplication.employee_id ORDER BY leaveapplication.dateapplied DESC LIMIT 3");
    while ($row = $result->fetch_assoc()) {

        $full_name = "{$row['lname']}, {$row['fname']} {$row['extname']} {$row['midname']}";
        echo "<tr class='text-center'>";
        echo "<td>{$row['employee_id']}</td>";
        echo "<td>{$full_name}</td>";
        echo "<td>{$row['leavetype']}</td>";
        echo "<td>{$row['dateapplied']}</td>";
        echo "</tr>";
    } 

?>

