<?php
include '../database/db_connect.php'; // Database connection

// Fetch only the start dates from both leaveapplication and travelorder
$query = "SELECT startdate FROM leaveapplication UNION SELECT startdate FROM travelorder";
$result = $conn->query($query);

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => "Events on this day",
        'start' => $row['startdate'],
        'color' => '#28a745', // Green color for event indicator
    ];
}

// Convert data to JSON for FullCalendar
$events_json = json_encode($events);
?>
