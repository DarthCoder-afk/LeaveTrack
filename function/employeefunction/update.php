<?php
include '../../database/db_connect.php';

if(isset($_POST['updateData'])) {
    session_start();

    $index_no = $_POST['index_no'];
    $new_emp_id = $_POST['employee_id'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $midname = $_POST['midname'];
    $gender = $_POST['gender'];
    $extname = $_POST['extname'];
    $position = $_POST['position'];
    $office = $_POST['office'];
    if ($office == "optional" && !empty($_POST['custom_office'])) {
        $office = $_POST['custom_office'];
    }
    $status = isset($_POST['status']) && $_POST['status'] === 'on' ? 'Active' : 'Inactive'; // Capture the status value
    
    echo '<script> console.log("'.$emp_id.'"); </script>';
    echo '<script> console.log("'.$new_emp_id.'"); </script>';

    // Check if employee_id already exists and is inactive
    $check_stmt = $conn->prepare("SELECT employee_id, status FROM employee WHERE employee_id = ? AND indexno != ?");
    $check_stmt->bind_param("si", $new_emp_id, $index_no);
    $check_stmt->execute();
    $check_stmt->store_result();
    $check_stmt->bind_result($existing_emp_id, $existing_status);
    $check_stmt->fetch();

    if ($check_stmt->num_rows > 0 && $existing_status == 'Active') {
        $_SESSION['message'] = "error_id";
        echo '<script> console.log("ID already exists and is Active. Only add employee with same ID if one is Inactive")</script>';
    } else {
        $stmt = $conn->prepare("UPDATE employee SET employee_id = ?, lname = ?, fname = ?, midname = ?, gender = ?, extname = ?, position = ?, office = ?, status = ? WHERE indexno = ?");
        $stmt->bind_param("sssssssssi", $new_emp_id, $lname, $fname, $midname, $gender, $extname, $position, $office, $status, $index_no);

        if($stmt->execute()) {
            $_SESSION['message'] = "update";
            echo '<script> console.log("'.$new_emp_id.'"); </script>';
            echo '<script> alert("Data Saved"); </script>';
        } else {
            $_SESSION['message'] = "error";
            echo '<script> alert("Data Not Saved"); </script>';
        }

        $stmt->close();
    }

    
    $conn->close();
    header('Location: ../../pages/employee_list.php');
    exit();
}
?>