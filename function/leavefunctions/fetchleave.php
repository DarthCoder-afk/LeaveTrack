<?php
    include '../database/db_connect.php';
    $result = $conn->query("SELECT * FROM employee, leaveapplication WHERE employee.employee_id = leaveapplication.employee_id");
    while ($row = $result->fetch_assoc()) {
        //$formatted_emp_id = sprintf('%03d', $row['employee_id']); // Format employee_id with leading zeros
        //$middle_initial = !empty($row['midname']) ? strtoupper($row['midname'][0]) . '.' : '';
        $full_name = "{$row['lname']}, {$row['fname']} {$row['extname']} {$row['midname']}";
        
        echo "<tr class='text-center'>";
        echo "<td>{$row['employee_id']}</td>";
        echo "<td>{$full_name}</td>";
        //echo "<td>{$row['gender']}</td>";
        echo "<td>{$row['position']}</td>";
        echo "<td>{$row['office']}</td>";
        echo "<td>{$row['leavetype']}</td>";
        echo "<td>{$row['dateapplied']}</td>";
        echo "<td>
                <button class='btn btn-success text-white'><i class='fas fa-eye'></i></button>
                <button class='btn btn-info' data-toggle='modal' data-target='#editLeaveModal'
                data-indexno= '{$row['index_no']}'
                data-employee_id='{$row['employee_id']}'
                data-lname='{$row['lname']}'
                data-fname='{$row['fname']}'
                data-midname='{$row['midname']}'
                data-extname='{$row['extname']}'
                data-position='{$row['position']}'
                data-office='{$row['office']}'
                data-gender='{$row['gender']}'
                data-leavetype='{$row['leavetype']}'
                data-dateapplied='{$row['dateapplied']}'
                data-startdate='{$row['startdate']}'
                data-enddate='{$row['enddate']}'
                data-numdays='{$row['numofdays']}'
                data-file='{$row['file']}'>
                <i class='fas fa-pencil-alt'></i>
                </button>
                <button class='btn btn-danger text-white deletebtn' data-indexno ='{$row['index_no']}'><i class='fas fa-trash-alt'></i></button>
            </td>";
        echo "</tr>";
    } 

?>

