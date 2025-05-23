<?php
    include '../database/db_connect.php';
    $result = $conn->query("SELECT * FROM employee WHERE status = 'Active'");
    while ($row = $result->fetch_assoc()) {
        $full_name = "{$row['lname']}, {$row['fname']} {$row['extname']} {$row['midname']}";
        echo "<tr class='text-center'>";
        echo "<td>{$row['employee_id']}</td>";
        echo "<td>{$full_name}</td>";
        echo "<td>{$row['position']}</td>";
        echo "<td>{$row['office']}</td>";

        echo "<td>
                <button class='btn btn-success text-white viewEmployeeBtn'
                        data-indexno='{$row['indexno']}'
                        data-employee_id='{$row['employee_id']}'
                        data-lname='{$row['lname']}'
                        data-fname='{$row['fname']}'
                        data-midname='{$row['midname']}'
                        data-extname='{$row['extname']}'
                        data-position='{$row['position']}'
                        data-office='{$row['office']}'
                        data-status='{$row['status']}'
                        data-gender='{$row['gender']}'>
                    <i class='fas fa-eye'></i>
                </button>

                <button class='btn btn-info' data-toggle='modal' data-target='#verifyModal2'
                data-employee_id='{$row['employee_id']}'
                data-index_no='{$row['indexno']}'
                data-lname='{$row['lname']}'
                data-fname='{$row['fname']}'
                data-midname='{$row['midname']}'
                data-extname='{$row['extname']}'
                data-position='{$row['position']}'
                data-office='{$row['office']}'
                data-gender='{$row['gender']}'
                data-status='{$row['status']}'>
                <i class='fas fa-pencil-alt'></i>
                </button>

                <button class='btn btn-danger text-white' data-toggle='modal' data-target='#verifyModal' 
                data-index_no='{$row['indexno']}'
                data-employee_id='{$row['employee_id']}'>
                <i class='fas fa-trash-alt'></i></button>
            </td>";
        echo "</tr>";
    }
?>
