<?php
    include '../database/db_connect.php';
    $result = $conn->query("SELECT leaveapplication.*, 
    COALESCE(employee.employee_id, leaveapplication.employee_id) AS employee_id, 
    COALESCE(employee.lname, leaveapplication.emp_lname) AS lname, 
    COALESCE(employee.fname, leaveapplication.emp_fname) AS fname, 
    COALESCE(employee.midname, leaveapplication.emp_midname) AS midname, 
    COALESCE(employee.extname, leaveapplication.emp_extname) AS extname,
    COALESCE(employee.position, 'N/A') AS position,
    COALESCE(employee.office, 'N/A') AS office,
    COALESCE(employee.gender, 'N/A') AS gender
    FROM leaveapplication 
    LEFT JOIN employee ON employee.indexno = leaveapplication.emp_index");

    while ($row = $result->fetch_assoc()) {
        //$formatted_emp_id = sprintf('%03d', $row['employee_id']); // Format employee_id with leading zeros
        //$middle_initial = !empty($row['midname']) ? strtoupper($row['midname'][0]) . '.' : '';
        $full_name = "{$row['lname']}, {$row['fname']} {$row['extname']} {$row['midname']}";
        $full_name = trim($full_name); 
        
        
        echo "<tr class='text-center'>";
        echo "<td>{$row['employee_id']}</td>";
        echo "<td>{$full_name}</td>";
        //echo "<td>{$row['gender']}</td>";
        // echo "<td>{$row['position']}</td>";
        // echo "<td>{$row['office']}</td>";
        echo "<td>{$row['leavetype']}</td>";
        echo "<td>{$row['dateapplied']}</td>";
        echo "<td>
                <button class='btn btn-success text-white viewLeaveBtn' 
                    data-indexno='{$row['index_no']}'
                    data-employee_id='{$row['employee_id']}'
                    data-fullname = '{$full_name}'
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
                    data-file='{$row['file']}'
                    data-toggle='modal' 
                    data-target='#viewLeaveModal'>
                    <i class='fas fa-eye'></i>
                </button>


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
                    data-date_type='{$row['date_type']}'
                    data-specific_dates='{$row['specific_dates']}'
                    data-startdate='{$row['startdate']}'
                    data-enddate='{$row['enddate']}'
                    data-numdays='{$row['numofdays']}'
                    data-file='{$row['file']}'>
                    <i class='fas fa-pencil-alt'></i>
                </button>
                <button class='btn btn-danger text-white' data-toggle='modal' data-target='#verifyModal' 
                data-indexno ='{$row['index_no']}'
                data-employee_id='{$row['employee_id']}'><i class='fas fa-trash-alt'></i></button>
            </td>";
        echo "</tr>";
    } 

?>

