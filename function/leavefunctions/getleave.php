<?php
include '../database/db_connect.php'; // Adjust path as needed

if (isset($_POST['leave_id'])) {
    $leave_id = $_POST['leave_id'];

    $query = "SELECT * FROM leave_applications WHERE leave_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $leave_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $leaveData = $result->fetch_assoc();

    echo json_encode($leaveData);
}
?>
