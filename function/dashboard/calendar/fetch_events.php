<?php
include '../../../database/db_connect.php'; // Move up three directories


$date = $_GET['date'];

$events = [];

// Fetch leave applications
$query = "SELECT employee_id, leavetype FROM leaveapplication WHERE startdate <= '$date' AND enddate >= '$date'";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'type' => 'Leave',
        'detail' => $row['leavetype'],
        'employee_id' => $row['employee_id']
    ];
}

// Fetch travel orders
$query = "SELECT employee_id, purpose, destination FROM travelorder WHERE startdate <= '$date' AND enddate >= '$date'";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'type' => 'Travel Order',
        'detail' => $row['purpose'] . " to " . $row['destination'],
        'employee_id' => $row['employee_id']
    ];
}

echo json_encode($events);
?>
