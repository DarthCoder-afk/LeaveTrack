<?php
include '../../database/db_connect.php';

$query = "SELECT * FROM tbl_employee WHERE status = 'Inactive' ORDER BY employee_id ASC";
$result = mysqli_query($connect, $query);

$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $fullName = $row['lname'] . ', ' . $row['fname'];
        if (!empty($row['midname'])) {
            $fullName .= ' ' . $row['midname'][0] . '.';
        }
        if (!empty($row['extname'])) {
            $fullName .= ' ' . $row['extname'];
        }

        $output .= '
        <tr class="inactive-row">
            <td>' . $row['employee_id'] . '</td>
            <td>' . $fullName . '</td>
            <td>' . $row['position'] . '</td>
            <td>' . $row['office'] . '</td>
            <td class="text-center">
                <button class="btn btn-info btn-sm" 
                    data-toggle="modal" 
                    data-target="#viewEmployeeModal" 
                    data-index_no="' . $row['index_no'] . '"
                    data-employee_id="' . $row['employee_id'] . '"
                    data-fname="' . $row['fname'] . '"
                    data-lname="' . $row['lname'] . '"
                    data-midname="' . $row['midname'] . '"
                    data-extname="' . $row['extname'] . '"
                    data-position="' . $row['position'] . '"
                    data-office="' . $row['office'] . '"
                    data-gender="' . $row['gender'] . '"
                    data-status="' . $row['status'] . '"
                    onclick="viewEmployee(this)">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-warning btn-sm" 
                    data-toggle="modal" 
                    data-target="#verifyModal2" 
                    data-index_no="' . $row['index_no'] . '"
                    data-employee_id="' . $row['employee_id'] . '"
                    data-fname="' . $row['fname'] . '"
                    data-lname="' . $row['lname'] . '"
                    data-midname="' . $row['midname'] . '"
                    data-extname="' . $row['extname'] . '"
                    data-position="' . $row['position'] . '"
                    data-office="' . $row['office'] . '"
                    data-gender="' . $row['gender'] . '"
                    data-status="' . $row['status'] . '">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>';
    }
} else {
    $output .= '<tr><td colspan="5" class="text-center">No inactive employees found</td></tr>';
}

echo $output;
?>