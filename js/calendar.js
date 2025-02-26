document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: eventsData,
        dateClick: function(info) {
            // Fetch event details for the selected date
            fetch(`../function/dashboard/calendar/fetch_events.php?date=${info.dateStr}`)
            .then(response => response.text())  // Change .json() to .text() to inspect raw output
            .then(data => {
                console.log("Server Response:", data);  // Debugging step
                let eventList = document.getElementById('eventList');
                eventList.innerHTML = "";
        
                let jsonData;
                try {
                    jsonData = JSON.parse(data);
                } catch (error) {
                    console.error("JSON Parse Error:", error);
                    eventList.innerHTML = "<li class='list-group-item text-danger'>Error parsing event data.</li>";
                    $('#eventModal').modal('show');
                    return;
                }
        
                if (jsonData.length > 0) {
                    jsonData.forEach(evt => {
                        let listItem = document.createElement("li");
                        listItem.classList.add("list-group-item");
                        listItem.innerHTML = `<strong>${evt.type}</strong>: ${evt.detail} <br> <small>Employee ID: ${evt.employee_id}</small>`;
                        eventList.appendChild(listItem);
                    });
                } else {
                    eventList.innerHTML = "<li class='list-group-item text-muted'>No events on this day.</li>";
                }
        
                $('#eventModal').modal('show');
            })
            .catch(error => {
                console.error("Fetch Error:", error);
                alert('Failed to fetch events. Please try again.');
            });
        
        }
    });

    calendar.render();
});
