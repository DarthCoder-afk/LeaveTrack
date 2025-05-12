<?php
include '../../database/db_connect.php';

if(isset($_POST['UpdateLeave'])) {
    session_start();

    $index_no = $_POST['index_no'];
    $emp_id = $_POST['employee_Id'];
    $leavetype = $_POST['leavetype'];

    // Check if leave type is optional, then use the user-specified leave type
    if ($leavetype === "Optional") {
        $leavetype = $_POST['optionalLeaveType']; // Get value from input
    }
    
    $date_type = $_POST['date_type2'];
    $specific_dates = isset($_POST['specific_dates']) ? $_POST['specific_dates'] : null;
    $datefiled = $_POST['applieddate'];
    $sdate = $_POST['startdate'];
    $edate = $_POST['enddate'];
    $ndays = isset($_POST['numdays']) ? floatval($_POST['numdays']) : 0;

    if ($date_type === 'specific' && $specific_dates) {
        $dates = explode(',', $specific_dates); // Assuming dates are comma-separated
        $ndays = isset($_POST['specificnumdays2']) ? floatval($_POST['specificnumdays2']) : 0;
        $sdate = null; // Not applicable for specific dates
        $edate = null; // Not applicable for specific dates
    }

    // File Upload - Only process if a file was actually uploaded
    if($_FILES['form']['size'] > 0 && !empty($_FILES['form']['name'])) {
        $file = time() . '_' . $_FILES['form']['name'];
        $file_temp = $_FILES['form']['tmp_name'];
        $file_destination = "../../uploads/" . $file;
        
        if(move_uploaded_file($file_temp, $file_destination)) {
            // File uploaded successfully, update database with new file
            $stmt = $conn->prepare("UPDATE leaveapplication SET leavetype = ?, dateapplied = ?, date_type = ?, specific_dates = ?, startdate = ?, enddate = ?, numofdays = ?, file = ? WHERE index_no = ?");
            $stmt->bind_param("ssssssssi", $leavetype, $datefiled, $date_type, $specific_dates, $sdate, $edate, $ndays, $file, $index_no);
        } else {
            // File upload failed
            $_SESSION['message'] = "file_upload_error";
            header('Location: ../../pages/applications.php');
            exit();
        }
    } else {
        // No new file uploaded, keep the existing file reference
        $stmt = $conn->prepare("UPDATE leaveapplication SET leavetype = ?, dateapplied = ?, date_type = ?, specific_dates = ?, startdate = ?, enddate = ?, numofdays = ? WHERE index_no = ?");
        $stmt->bind_param("sssssssi", $leavetype, $datefiled, $date_type, $specific_dates, $sdate, $edate, $ndays, $index_no);
    }

    if($stmt->execute()) {
        $_SESSION['message'] = "update";
        date_default_timezone_set('Asia/Manila');
        $activity_type = 'Leave Application';
        $activity_details = 'updated';
        $activity_date = date('Y-m-d');
        $activity_time = date("H:i");
        
        $log_stmt = $conn->prepare("INSERT INTO activity_log (emp_id, activity_type, activity_details, activity_date, activity_time) VALUES (?, ?, ?, ?, ?)");
        $log_stmt->bind_param("sssss", $emp_id, $activity_type, $activity_details, $activity_date, $activity_time);
        $log_stmt->execute();
        $log_stmt->close();
    } else {
        $_SESSION['message'] = "error";
        echo '<script> console.log("Error: '.$stmt->error.'"); </script>';
    }

    $stmt->close();
    $conn->close();
    header('Location: ../../pages/applications.php');
    exit();
}
?>