<?php
include '../../database/db_connect.php';

header('Content-Type: application/json');

if(isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];
    

    $stmt = $conn->prepare("SELECT indexno, lname, fname, midname, gender, extname, position, office FROM employee WHERE employee_id = ? AND status='Active'");
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        echo json_encode($employee);
    } else {
        echo json_encode(["error" => "Employee not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>