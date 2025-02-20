<?php 
include '../../database/db_connect.php';

if(isset($_POST['AddLeave'])) {
    session_start();

    $emp_id = $_POST['employee_Id'];
    $ltype = $_POST['leavetype'];
    $applieddate = $_POST['applieddate'];
    $sdate = $_POST['startdate'];
    $edate = $_POST['enddate'];
    $numdays = $_POST['numdays'];
    $form = $_POST['form'];

    $stmt = $conn->prepare("INSERT INTO leaveapplication (employee_Id, leavetype, dateapplied, startdate, enddate, numofdays, file) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $emp_id, $ltype, $applieddate, $sdate, $edate, $numdays, $form);

    if($stmt->execute()) {
        $_SESSION['message'] = "success";
        echo '<script> alert("Data Saved"); </script>';
       
    } else {
        $_SESSION['message'] = "error";
        echo '<script> alert("Data Not Saved"); </script>';
    }

    $stmt->close();
    $conn->close();
    header('Location: ../../pages/applications.php');
}
?>