<?php 
include '../../database/db_connect.php';

if(isset($_POST['AddLeave'])) {
    session_start();

    $emp_index = $_POST['emp_index'];
    $emp_id = $_POST['employee_Id'];
    $ltype = $_POST['leavetype'];

    // Check if leave type is optional, then use the user-specified leave type
    if ($ltype === "Optional") {
        $ltype = $_POST['optional_leavetype']; // Get value from hidden input
    }

    $applieddate = $_POST['applieddate'];
    $sdate = $_POST['startdate'];
    $edate = $_POST['enddate'];
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

    // Insert Leave Application
    $stmt = $conn->prepare("INSERT INTO leaveapplication 
        (emp_index, employee_Id, emp_lname, emp_fname, emp_midname, emp_extname, leavetype, dateapplied, startdate, enddate, numofdays, file) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssssss", $emp_index, $emp_id, $lname, $fname, $midname, $extname, $ltype, $applieddate, $sdate, $edate, $numdays, $file);

    if ($stmt->execute()) {
        $_SESSION['message'] = "success";
        echo '<script> alert("Data Saved"); </script>';

        // Insert Activity Log
        date_default_timezone_set('Asia/Manila');
        $activity_type = 'Leave Application';
        $activity_details = 'added';
        $activity_date = date('Y-m-d');
        $activity_time = date("H:i");

        $log_stmt = $conn->prepare("INSERT INTO activity_log (emp_id, activity_type, activity_details, activity_date, activity_time) 
                                    VALUES (?, ?, ?, ?, ?)");
        $log_stmt->bind_param("sssss", $emp_id, $activity_type, $activity_details, $activity_date, $activity_time);
        $log_stmt->execute();
        $log_stmt->close();
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
