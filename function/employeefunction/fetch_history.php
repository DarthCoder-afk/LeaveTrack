<?php
include '../../database/db_connect.php';

$response = ["leave" => [], "travel" => []];

if (isset($_POST['employee_id']) && isset($_POST['indexno'])) {
    $employee_id = $_POST['employee_id'];
    $indexno = $_POST['indexno'];

    error_log("Fetching history for: Employee ID = $employee_id, Index No = $indexno"); // Debugging

    $response = ["leave" => [], "travel" => []];

    // Fetch Leave History based on indexno
    $leaveQuery = "SELECT leavetype, startdate, enddate, numofdays, date_type, specific_dates
    FROM leaveapplication 
    WHERE emp_index = ?";

    $stmt = $conn->prepare($leaveQuery);
    $stmt->bind_param("s", $indexno);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response['leave'][] = $row;
    }
    $stmt->close();

    // Fetch Travel History based on indexno
    $travelQuery = "SELECT purpose, destination, startdate, enddate 
                    FROM travelorder 
                    WHERE emp_index = ?";
    $stmt = $conn->prepare($travelQuery);
    $stmt->bind_param("s", $indexno);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response['travel'][] = $row;
    }
    $stmt->close();

    error_log("Received employee_id: " . $_POST['employee_id']);
    error_log("Received indexno: " . $_POST['indexno']);


    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    error_log("Missing employee_id or indexno in request!"); // Debugging
    echo json_encode(["error" => "Missing employee_id or indexno"]);
}

?>
