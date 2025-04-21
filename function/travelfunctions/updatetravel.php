<?php
include '../../database/db_connect.php';

if(isset($_POST['EditTravel'])) {
    session_start();

    $index_no = $_POST['index_no'];
    $emp_id = $_POST['employee_Id'];
    $purpose = $_POST['purpose'];
    $destination = $_POST['destination'];
    $datefiled = $_POST['applieddate'];
    $sdate = $_POST['startdate'];
    $edate = $_POST['enddate'];
    $ndays = isset($_POST['numdays']) ? floatval($_POST['numdays']) : 0;
    $date_type = $_POST['date_type2'];
    $specific_dates = isset($_POST['specific_dates']) ? $_POST['specific_dates'] : null;

    if ($date_type === 'specific' && $specific_dates) {
        $dates = explode(',', $specific_dates); // Assuming dates are comma-separated
        $ndays = isset($_POST['specificnumdays2']) ? floatval($_POST['specificnumdays2']) : 0;
        $sdate = null; // Not applicable for specific dates
        $edate = null; // Not applicable for specific dates
    }

    // File Upload
    $file = $_FILES['form']['name'];
    $file_temp = $_FILES['form']['tmp_name'];
    $unique_file_name = time() . '_' . $file; // Append a timestamp to the file name
    $file_destination = "../../uploads/".($unique_file_name);
    move_uploaded_file($file_temp, $file_destination);
    
    echo '<script> console.log("'.$index_no.'"); </script>';
    //echo '<script> console.log("'.$new_emp_id.'"); </script>';

    $stmt = $conn->prepare("UPDATE travelorder SET purpose = ?, destination = ?, dateapplied = ?, date_type = ?, specific_dates = ?, startdate = ?, enddate = ?, numofdays = ?, file = ? WHERE index_no = ?");
    $stmt->bind_param("sssssssssi", $purpose, $destination, $datefiled, $date_type, $specific_dates, $sdate, $edate, $ndays, $file, $index_no);

    if($stmt->execute()) {
        $_SESSION['message'] = "update";
        //echo '<script> console.log("'.$new_emp_id.'"); </script>';
        echo '<script> alert("Data Updated"); </script>';
        date_default_timezone_set('Asia/Manila');
        $activity_type = 'Travel Order';
        $activity_details = 'updated';
        $activity_date = date('Y-m-d');
        $activity_time = date("H:i");
        $log_stmt = $conn->prepare("INSERT INTO activity_log (emp_id, activity_type, activity_details, activity_date, activity_time) VALUES (?, ?, ?, ?, ?)");
        $log_stmt->bind_param("sssss", $emp_id, $activity_type, $activity_details, $activity_date, $activity_time);
        $log_stmt->execute();
        $log_stmt->close();
    } else {
        $_SESSION['message'] = "error";
        echo '<script> alert("Data Not Saved"); </script>';
        echo '<script> console.log("Error: '.$stmt->error.'"); </script>';
    }

    $stmt->close();
    $conn->close();
    header('Location: ../../pages/travel_order.php');
    exit();
}
?>