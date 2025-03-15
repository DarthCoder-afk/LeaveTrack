<?php
include '../../../database/db_connect.php'; // Move up three directories

$date = $_GET['date'];

$events = [];

// Fetch leave applications (JOIN with employee table)
$query = "
    SELECT e.indexno, e.employee_id, 
           CONCAT(e.lname, ', ', e.fname, ' ', COALESCE(e.extname, ''), ' ', COALESCE(e.midname, '')) AS full_name, 
           l.leavetype 
    FROM leaveapplication l 
    JOIN employee e ON e.indexno = l.emp_index 
    WHERE l.startdate = '$date'
";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'type' => 'Leave',
        'detail' => $row['leavetype'],
        'employee_id' => $row['employee_id'],
        'full_name' => $row['full_name']
    ];
}

// Fetch travel orders (JOIN with employee table)
$query = "
    SELECT e.indexno, e.employee_id, 
           CONCAT(e.lname, ', ', e.fname, ' ', COALESCE(e.extname, ''), ' ', COALESCE(e.midname, '')) AS full_name, 
           t.purpose, t.destination 
    FROM travelorder t 
    JOIN employee e ON e.indexno = t.emp_index 
    WHERE t.startdate = '$date'
";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'type' => 'Travel Order',
        'detail' => $row['purpose'] . " to " . $row['destination'],
        'employee_id' => $row['employee_id'],
        'full_name' => $row['full_name']
    ];
}

echo json_encode($events);
?>
