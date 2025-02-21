<?php
include '../../database/db_connect.php';

if(isset($_GET['employee_id'])) {
    session_start();

    $employee_id = $_GET['employee_id'];


    $stmt = $conn->prepare("DELETE FROM leaveapplication WHERE employee_id = ?");
    $stmt->bind_param("s", $employee_id);

    if($stmt->execute()) {
        $_SESSION['message'] = "delete";
        echo '<script> alert("Data Saved"); </script>';
    } else {
        $_SESSION['message'] = "error";
        echo '<script> alert("Data Not Saved"); </script>';
    }

    $stmt->close();
    $conn->close();
    header('Location: ../../pages/applications.php');
    exit();
}
?>