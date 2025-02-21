<?php
include '../../database/db_connect.php';

if(isset($_POST['UpdateLeave'])) {
    session_start();

    $emp_id = $_POST['employee_Id'];
    $leavetype = $_POST['leavetype'];
    $datefiled = $_POST['applieddate'];
    $sdate = $_POST['startdate'];
    $edate = $_POST['enddate'];
    $ndays = $_POST['numdays'];

    // File Upload
    $file = $_FILES['form']['name'];
    $file_temp = $_FILES['form']['tmp_name'];
    $file_destination = "../../uploads/".($file);
    move_uploaded_file($file_temp, $file_destination);
    
    echo '<script> console.log("'.$emp_id.'"); </script>';
    //echo '<script> console.log("'.$new_emp_id.'"); </script>';

    $stmt = $conn->prepare("UPDATE leaveapplication SET leavetype = ?, dateapplied = ?, startdate = ?, enddate = ?, numofdays = ?, file = ? WHERE employee_id = ?");
    $stmt->bind_param("sssssss", $leavetype, $datefiled, $sdate, $edate, $ndays, $file, $emp_id);

    if($stmt->execute()) {
        $_SESSION['message'] = "update";
        //echo '<script> console.log("'.$new_emp_id.'"); </script>';
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