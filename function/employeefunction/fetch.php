<?php
    include '../database/db_connect.php';
    $result = $conn->query("SELECT * FROM employee");
    while ($row = $result->fetch_assoc()) {
        $full_name = "{$row['lname']}, {$row['fname']} {$row['extname']} {$row['midname']}";
        echo "<tr class='text-center'>";
        echo "<td>{$row['employee_id']}</td>";
        echo "<td>{$full_name}</td>";
        echo "<td>{$row['position']}</td>";
        echo "<td>{$row['office']}</td>";
        echo "<td>
                <button class='btn btn-success text-white viewbtn'
                data-toggle='modal' data-target='#viewEmployeeModal'
                data-employee_id='{$row['employee_id']}'
                data-lname='{$row['lname']}'
                data-fname='{$row['fname']}'
                data-midname='{$row['midname']}'
                data-extname='{$row['extname']}'
                data-position='{$row['position']}'
                data-office='{$row['office']}'
                data-gender='{$row['gender']}'>
                <i class='fas fa-eye'></i>
                </button>
                
                <button class='btn btn-info' data-toggle='modal' data-target='#editEmployeeModal'
                data-employee_id='{$row['employee_id']}'
                data-lname='{$row['lname']}'
                data-fname='{$row['fname']}'
                data-midname='{$row['midname']}'
                data-extname='{$row['extname']}'
                data-position='{$row['position']}'
                data-office='{$row['office']}'
                data-gender='{$row['gender']}'>
                <i class='fas fa-pencil-alt'></i>
                </button>
                <button class='btn btn-danger text-white deletebtn' data-employee_id='{$row['employee_id']}'><i class='fas fa-trash-alt'></i></button>
            </td>";
        echo "</tr>";
    } 

?>

