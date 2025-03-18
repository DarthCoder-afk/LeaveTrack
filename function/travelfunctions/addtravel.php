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
  
    // File Upload
    $file = $_FILES['form']['name'];
    $file_temp = $_FILES['form']['tmp_name'];
    $file_destination = "../../uploads/".($file);
    move_uploaded_file($file_temp, $file_destination);

    $stmt = $conn->prepare("INSERT INTO travelorder (emp_index, employee_id, purpose, destination, dateapplied, startdate, enddate, numofdays, file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss",  $emp_index, $emp_id, $purpose, $destination, $dateapplied, $startdate, $enddate, $numdays, $file);

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