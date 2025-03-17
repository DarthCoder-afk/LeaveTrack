<?php
include '../../database/db_connect.php';

if(isset($_GET['index_no'])) {
    session_start();

    $index_no = $_GET['index_no'];
    $emp_id = $_GET['employee_id'];


    $stmt = $conn->prepare("DELETE FROM employee WHERE indexno = ?");
    $stmt->bind_param("s", $index_no);

    if($stmt->execute()) {
        $_SESSION['message'] = "delete";
        echo '<script> alert("Data Deleted"); </script>';

        // Insert activity log
        date_default_timezone_set('Asia/Manila');
        $activity_type = 'employee';
        $activity_details = 'deleted';
        $activity_date = date('Y-m-d');
        $activity_time = date("H:i");
        $log_stmt = $conn->prepare("INSERT INTO activity_log (emp_id, activity_type, activity_details, activity_date, activity_time) VALUES (?, ?, ?, ?, ?)");
        $log_stmt->bind_param("sssss", $emp_id, $activity_type, $activity_details, $activity_date, $activity_time);
        $log_stmt->execute();
        $log_stmt->close();
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