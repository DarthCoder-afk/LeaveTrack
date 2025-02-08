document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        dateClick: function(info) {
            console.log("Clicked date: " + info.dateStr); // Debugging console log
            alert("Clicked date: " + info.dateStr); // Test alert
            window.location.href = "event.php?date=" + info.dateStr; // Redirect to event.php
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
