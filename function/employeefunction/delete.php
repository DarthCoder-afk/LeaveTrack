<?php
include '../../database/db_connect.php';

if(isset($_GET['index_no'])) {
    session_start();

    $index_no = $_GET['index_no'];


    $stmt = $conn->prepare("DELETE FROM employee WHERE indexno = ?");
    $stmt->bind_param("s", $index_no);

    if($stmt->execute()) {
        $_SESSION['message'] = "delete";
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