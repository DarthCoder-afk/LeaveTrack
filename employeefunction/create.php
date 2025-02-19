<?php 
include '../database/db_connect.php';

if(isset($_POST['createData'])) {
    session_start();

    $emp_id = $_POST['employee_id'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $midname = $_POST['midname'];
    $extname = $_POST['extname'];
    $position = $_POST['position'];
    $office = $_POST['office'];

    $stmt = $conn->prepare("INSERT INTO employee (employee_id, lname, fname, midname, extname, position, office) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $emp_id, $lname, $fname, $midname, $extname, $position, $office);

    if($stmt->execute()) {
        $_SESSION['message'] = "success";
        echo '<script> alert("Data Saved"); </script>';
       
    } else {
        $_SESSION['message'] = "error";
        echo '<script> alert("Data Not Saved"); </script>';
    }

    $stmt->close();
    $conn->close();
    header('Location: ../pages/employee_list.php');
}
?>