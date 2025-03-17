<?php 
include '../../database/db_connect.php';

if(isset($_POST['createData'])) {
    session_start();

    $emp_id = $_POST['employee_id'];
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
    $status = "Active";

    // Check if employee_id already exists and is inactive
    $check_stmt = $conn->prepare("SELECT employee_id, status FROM employee WHERE employee_id = ?");
    $check_stmt->bind_param("s", $emp_id);
    $check_stmt->execute();
    $check_stmt->store_result();
    $check_stmt->bind_result($existing_emp_id, $existing_status);
    $check_stmt->fetch();

    if($check_stmt->num_rows > 0 && $existing_status == 'Active') {
        $_SESSION['message'] = "error_id";
        echo '<script> console.log("ID already exists and is Active. Only add employee with same ID if one is Inactive")</script>';
    } else {
        $stmt = $conn->prepare("INSERT INTO employee (employee_id, lname, fname, midname, extname, gender, position, office, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $emp_id, $lname, $fname, $midname, $extname, $gender, $position, $office, $status);
    
        if($stmt->execute()) {
            $_SESSION['message'] = "success";
            echo '<script> alert("Data Saved"); </script>';
               // Insert activity log
            date_default_timezone_set('Asia/Manila');
            $activity_type = 'Employee';
            $activity_details = 'added';
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
    }
    
    $check_stmt->close();
    $conn->close();
    header('Location: ../../pages/employee_list.php');
}
?>