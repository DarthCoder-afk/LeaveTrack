<?php
include 'auth.php'; // Ensure authentication

//echo "Welcome, " . $_SESSION['username'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Incentive Leave Calendar</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="calendar.css">
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Service Incentive Leave Calendar</h2>
    <div id="calendar"></div>
</div>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<!-- Clickable Date JS -->
<script src="calendar.js"></script>

</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                { title: 'New', start: '2024-02-05' },
                { title: 'Divyesh Birthday', start: '2024-02-07' },
                { title: 'Car Loan EMI', start: '2024-02-10' },
                { title: 'Independence Day', start: '2024-02-15' },
                { title: '3 Days Event', start: '2024-02-17', end: '2024-02-19' }
            ]
        });
        calendar.render();
    });
</script>



</body>
</html>
