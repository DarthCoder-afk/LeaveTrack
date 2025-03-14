<?php
    include '../database/db_connect.php';

    // Corrected SQL query using emp_index to match employee.index_no
    $query = "
        SELECT 
            leaveapplication.index_no AS leave_id, 
            employee.employee_id AS id_no, 
            employee.lname, 
            employee.fname, 
            employee.extname, 
            employee.midname, 
            leaveapplication.leavetype,  -- Correct Leave Type
            leaveapplication.dateapplied -- Correct Applied Date
        FROM leaveapplication
        INNER JOIN employee ON employee.indexno = leaveapplication.emp_index  -- FIXED JOIN
        ORDER BY leaveapplication.dateapplied DESC 
        LIMIT 3
    ";

    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $full_name = "{$row['lname']}, {$row['fname']} {$row['extname']} {$row['midname']}";

        echo "<tr class='text-center'>";
        echo "<td>{$row['id_no']}</td>"; // Employee ID
        echo "<td>{$full_name}</td>";
        echo "<td>{$row['leavetype']}</td>"; // Fixed Leave Type
        echo "<td>{$row['dateapplied']}</td>"; // Fixed Applied Date
        echo "</tr>";
    } 
?>
