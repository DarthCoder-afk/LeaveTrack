<?php
    include '../database/db_connect.php';

    $result = $conn->query("SELECT travelorder.*, 
    COALESCE(employee.employee_id, travelorder.employee_id) AS employee_id, 
    COALESCE(employee.lname, travelorder.emp_lname) AS lname, 
    COALESCE(employee.fname, travelorder.emp_fname) AS fname, 
    COALESCE(employee.midname, travelorder.emp_midname) AS midname, 
    COALESCE(employee.extname, travelorder.emp_extname) AS extname,
    COALESCE(employee.position, 'N/A') AS position,
    COALESCE(employee.office, 'N/A') AS office,
    COALESCE(employee.gender, 'N/A') AS gender,
    COALESCE(employee.status, 'N/A') AS status
    FROM travelorder 
    LEFT JOIN employee ON employee.indexno = travelorder.emp_index");
    while ($row = $result->fetch_assoc()) {
        $full_name = "{$row['lname']}, {$row['fname']} {$row['extname']} {$row['midname']}";
        $full_name = trim($full_name); 
        $row_class = ($row['status'] == 'Inactive') ? 'inactive-row' : '';
        $dateapplied = ($row['dateapplied'] === '0000-00-00') ? 'No Record' :  htmlspecialchars(date("F d, Y", strtotime($row['dateapplied'])), ENT_QUOTES) ;
        
        echo "<tr class='text-center {$row_class}'>";
        echo "<td>{$row['employee_id']}</td>";
        echo "<td>{$full_name}</td>";
        echo "<td>{$row['position']}</td>";
        echo "<td style='white-space: normal; word-wrap: break-word;'>{$row['purpose']}</td>";
        echo "<td>{$dateapplied}</td>";
        echo "<td>
                <button class='btn btn-success text-white viewTravelBtn' 
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
                    data-purpose='{$row['purpose']}'
                    data-destination='{$row['destination']}'
                    data-dateapplied='{$row['dateapplied']}'
                    data-datetype='{$row['date_type']}'
                    data-specificdates='{$row['specific_dates']}'
                    data-startdate='{$row['startdate']}'
                    data-enddate='{$row['enddate']}'
                    data-numdays='{$row['numofdays']}'
                    data-file='{$row['file']}'
                    data-toggle='modal' 
                    data-target='#ViewTravelModal'>
                    <i class='fas fa-eye'></i>
                </button>


                <button class='btn btn-info' data-toggle='modal' data-target='#verifyModal2'
                    data-indexno= '{$row['index_no']}'
                    data-employee_id='{$row['employee_id']}'
                    data-lname='{$row['lname']}'
                    data-fname='{$row['fname']}'
                    data-midname='{$row['midname']}'
                    data-extname='{$row['extname']}'
                    data-position='{$row['position']}'
                    data-office='{$row['office']}'
                    data-purpose='{$row['purpose']}'
                    data-destination='{$row['destination']}'
                    data-dateapplied='{$row['dateapplied']}'
                    data-startdate='{$row['startdate']}'
                    data-date_type='{$row['date_type']}'
                    data-specific_dates='{$row['specific_dates']}'
                    data-enddate='{$row['enddate']}'
                    data-numdays='{$row['numofdays']}'
                    data-file='{$row['file']}'>
                    <i class='fas fa-pencil-alt'></i>
                </button>
                <button class='btn btn-danger text-white' data-toggle='modal' data-target='#verifyModal' data-indexno ='{$row['index_no']}'
                data-employee_id='{$row['employee_id']}'><i class='fas fa-trash-alt'></i></button>
            </td>";
        echo "</tr>";
    } 

?>

