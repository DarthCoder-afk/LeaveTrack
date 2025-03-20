<?php 
include '../../database/db_connect.php';

if(isset($_POST['AddTravel'])) {
    session_start();

    $emp_index = $_POST['emp_index'];
    $emp_id = $_POST['employee_Id'];
    $purpose = $_POST['pur'];
    $destination = $_POST['des'];
    $dateapplied = $_POST['datefiled'];
    $startdate = $_POST['sdate'];
    $enddate = $_POST['edate'];
    $numdays = $_POST['numdays'];
  
    // File Upload Handling
    $file = $_FILES['form']['name'];
    $file_temp = $_FILES['form']['tmp_name'];
    $upload_dir = "../../uploads/";
    $file_destination = $upload_dir . basename($file);

    if (!empty($file)) {
        move_uploaded_file($file_temp, $file_destination);
    } else {
        $file = NULL; // If no file is uploaded, store NULL
    }


    // Fetch Employee Details
    $stmt = $conn->prepare("SELECT employee_id, lname, fname, midname, extname FROM employee WHERE indexno = ?");
    $stmt->bind_param("i", $emp_index);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    $stmt->close();

    if ($employee) {
        $lname = $employee['lname'];
        $fname = $employee['fname'];
        $midname = $employee['midname'];
        $extname = $employee['extname'];
    } else {
        $lname = $fname = $midname = $extname = "Unknown";
    }

     // Insert Travel Application
    $stmt = $conn->prepare("INSERT INTO travelorder 
    (emp_index, employee_Id, emp_lname, emp_fname, emp_midname, emp_extname, purpose, destination, dateapplied, startdate, enddate, numofdays, file) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssssssss", $emp_index, $emp_id, $lname, $fname, $midname, $extname, $purpose, $destination, $dateapplied, $startdate, $enddate, $numdays, $file);


    if($stmt->execute()) {
        $_SESSION['message'] = "success";
        echo '<script> alert("Data Saved"); </script>';
        date_default_timezone_set('Asia/Manila');
        $activity_type = 'Travel Order';
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
    $conn->close();
    header('Location: ../../pages/travel_order.php');
}
?>