<?php
include '../../database/db_connect.php';

if(isset($_POST['EditTravel'])) {
    session_start();

    $index_no = $_POST['index_no'];
    $emp_id = $_POST['employee_Id'];
    $purpose = $_POST['purpose'];
    $destination = $_POST['destination'];
    $datefiled = $_POST['datefiled'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $ndays = $_POST['days'];

    // File Upload
    $file = $_FILES['form']['name'];
    $file_temp = $_FILES['form']['tmp_name'];
    $unique_file_name = time() . '_' . $file; // Append a timestamp to the file name
    $file_destination = "../../uploads/".($unique_file_name);
    move_uploaded_file($file_temp, $file_destination);
    
    echo '<script> console.log("'.$index_no.'"); </script>';
    //echo '<script> console.log("'.$new_emp_id.'"); </script>';

    $stmt = $conn->prepare("UPDATE travelorder SET purpose = ?, destination = ?, dateapplied = ?, startdate = ?, enddate = ?, numofdays = ?, file = ? WHERE index_no = ?");
    $stmt->bind_param("sssssisi", $purpose, $destination, $datefiled, $sdate, $edate, $ndays, $file, $index_no);

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