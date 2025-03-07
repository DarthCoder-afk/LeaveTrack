<?php
include '../../database/db_connect.php';

if(isset($_POST['updateData'])) {
    session_start();

    $emp_id = $_POST['hidden_employee_id'];
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

    $stmt = $conn->prepare("UPDATE employee SET employee_id = ?, lname = ?, fname = ?, midname = ?, gender = ?, extname = ?, position = ?, office = ?, status = ? WHERE employee_id = ?");
    $stmt->bind_param("ssssssssss", $new_emp_id, $lname, $fname, $midname, $gender, $extname, $position, $office, $status, $emp_id);

    if($stmt->execute()) {
        $_SESSION['message'] = "update";
        echo '<script> console.log("'.$new_emp_id.'"); </script>';
        echo '<script> alert("Data Saved"); </script>';
    } else {
        $_SESSION['message'] = "error";
        echo '<script> alert("Data Not Saved"); </script>';
    }

    $stmt->close();
    $conn->close();
    header('Location: ../../pages/employee_list.php');
    exit();
}
?>