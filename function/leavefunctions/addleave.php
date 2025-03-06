<?php 
include '../../database/db_connect.php';

if(isset($_POST['AddLeave'])) {
    session_start();

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

    // File Upload
    $file = $_FILES['form']['name'];
    $file_temp = $_FILES['form']['tmp_name'];
    $file_destination = "../../uploads/".($file);
    move_uploaded_file($file_temp, $file_destination);

    $stmt = $conn->prepare("INSERT INTO leaveapplication (employee_Id, leavetype, dateapplied, startdate, enddate, numofdays, file) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $emp_id, $ltype, $applieddate, $sdate, $edate, $numdays, $file);

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
