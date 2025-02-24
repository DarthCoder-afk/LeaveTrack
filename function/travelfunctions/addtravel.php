<?php 
include '../../database/db_connect.php';

if(isset($_POST['AddTravel'])) {
    session_start();

    $emp_id = $_POST['employee_Id'];
    $purpose = $_POST['pur'];
    $destination = $_POST['des'];
    $dateapplied = $_POST['datefiled'];
    $startdate = $_POST['sdate'];
    $enddate = $_POST['edate'];
    $numdays = $_POST['days'];
  

     // File Upload
     $file = $_FILES['form']['name'];
     $file_temp = $_FILES['form']['tmp_name'];
     $file_destination = "../../uploads/".($file);
     move_uploaded_file($file_temp, $file_destination);

    $stmt = $conn->prepare("INSERT INTO travelorder (employee_id, purpose, destination, dateapplied, startdate, enddate, numofdays, file) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssis", $emp_id, $purpose, $destination, $dateapplied, $startdate, $enddate, $numdays, $file);

    if($stmt->execute()) {
        $_SESSION['message'] = "success";
        echo '<script> alert("Data Saved"); </script>';
       
    } else {
        $_SESSION['message'] = "error";
        echo '<script> alert("Data Not Saved"); </script>';
    }

    $stmt->close();
    $conn->close();
    header('Location: ../../pages/travel_order.php');
}
?>