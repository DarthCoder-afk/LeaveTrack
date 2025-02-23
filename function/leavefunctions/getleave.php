<?php
include '../../database/db_connect.php';

if (isset($_POST['index_no'])) {
    $leave_id = $_POST['index_no'];

    $query = "SELECT * FROM leaveapplication WHERE index_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $leave_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $leaveData = $result->fetch_assoc();

    echo json_encode($leaveData);
}
?>
