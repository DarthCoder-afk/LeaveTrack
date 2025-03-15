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
            fetch(`../function/dashboard/calendar/fetch_events.php?date=${info.dateStr}`)
            .then(response => response.json())
            .then(data => {
                console.log("Server Response:", data);
                let eventList = document.getElementById('eventList');
                eventList.innerHTML = "";

                if (data.length > 0) {
                    data.forEach(evt => {
                        let listItem = document.createElement("li");
                        listItem.classList.add("list-group-item");
                        listItem.innerHTML = `<strong>${evt.type}</strong>: ${evt.detail} <br> 
                                              <small><strong>Employee:</strong> ${evt.full_name} (${evt.employee_id})</small>`;
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
