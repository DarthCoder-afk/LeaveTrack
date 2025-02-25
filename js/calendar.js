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
            fetch(`fetch_events.php?date=${info.dateStr}`)
                .then(response => response.json())
                .then(data => {
                    let eventList = document.getElementById('eventList');
                    eventList.innerHTML = ""; // Clear previous data

                    if (data.length > 0) {
                        data.forEach(evt => {
                            let listItem = document.createElement("li");
                            listItem.classList.add("list-group-item");
                            listItem.innerText = `${evt.type}: ${evt.detail} (Employee ID: ${evt.employee_id})`;
                            eventList.appendChild(listItem);
                        });

                        // Show the modal
                        $('#eventModal').modal('show');
                    } else {
                        // Show message if no events exist
                        eventList.innerHTML = "<li class='list-group-item'>No events on this day.</li>";
                        $('#eventModal').modal('show');
                    }
                })
                .catch(error => console.error('Error fetching events:', error));
        }
    });

    calendar.render();
});
