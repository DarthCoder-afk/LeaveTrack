<?php
include '../../database/db_connect.php';

if(isset($_POST['updateData'])) {
    session_start();

    $emp_id = $_POST['employee_id'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $midname = $_POST['midname'];
    $gender = $_POST['gender'];
    $extname = $_POST['extname'];
    $position = $_POST['position'];
    $office = $_POST['office'];

    $stmt = $conn->prepare("UPDATE employee SET lname = ?, fname = ?, midname = ?, gender = ?, extname = ?, position = ?, office = ? WHERE employee_id = ?");
    $stmt->bind_param("ssssssss", $lname, $fname, $midname, $gender, $extname, $position, $office, $emp_id);

    if($stmt->execute()) {
        $_SESSION['message'] = "update";
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