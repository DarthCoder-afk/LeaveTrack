<?php
include '../../database/db_connect.php';


$response = ["leave" => [], "travel" => []];

if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];

    // Fetch Leave History
    $leaveQuery = "SELECT leavetype, startdate, enddate, numofdays FROM leaveapplication WHERE employee_id = ?";
    $stmt = $conn->prepare($leaveQuery);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response['leave'][] = $row;
    }
    $stmt->close();

    // Fetch Travel History
    $travelQuery = "SELECT purpose, destination, startdate, enddate FROM travelorder WHERE employee_id = ?";
    $stmt = $conn->prepare($travelQuery);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response['travel'][] = $row;
    }
    $stmt->close();
}

// Debugging Output
header('Content-Type: application/json');
echo json_encode($response);
?>
