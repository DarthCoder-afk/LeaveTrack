$(document).on('click', '.viewEmployeeBtn', function () {
    console.log("View button clicked!");

    // Get employee details
    var employee_id = $(this).data('employee_id');
    var indexno = $(this).data('indexno'); // Fetch the index number
    var lname = $(this).data('lname');
    var fname = $(this).data('fname');
    var midname = $(this).data('midname');
    var extname = $(this).data('extname');
    var position = $(this).data('position');
    var office = $(this).data('office');
    var gender = $(this).data('gender');
    var status = $(this).data('status');

    console.log("Data Retrieved:", { employee_id, indexno, lname, fname, office, gender, status });

    var fullName = lname + ", " + fname + " " + (extname ? extname + " " : "") + (midname ? midname : "");

    // Update Profile Section
    $('#profileIdNumber').text(employee_id);
    $('#fullName').text(fullName);

    // Change Profile Picture Based on Gender
    var profilePic = $("#profilePic");
    if (gender.toLowerCase() === "male") {
        profilePic.attr("src", "../img/male_profile.png");
    } else if (gender.toLowerCase() === "female") {
        profilePic.attr("src", "../img/female_profile.png");
    } else {
        profilePic.attr("src", "../img/profile_app.jpg");
    }

    // Set values for the view modal
    $('#view_employee_id').val(employee_id);
    $('#view_lname').val(lname);
    $('#view_fname').val(fname);
    $('#view_midname').val(midname);
    $('#view_extname').val(extname);
    $('#view_position').val(position);
    $('#view_office').val(office);
    $('#view_gender').val(gender);
    $('#view_status').val(status);
    
    // Fetch Leave & Travel History with employee_id and indexno
    $.ajax({
        url: '../function/employeefunction/fetch_history.php',
        type: 'POST',
        data: { employee_id: employee_id, indexno: indexno },
        dataType: 'json',
        success: function (response) {
            console.log("History Fetched:", response); // Debugging

            // Leave History
            var leaveHtml = "";
            if (response.leave.length > 0) {
                response.leave.forEach(function (leave) {
                    const isSpecific = leave.date_type === 'specific';

                    const startDate = isSpecific ? 'N/A' : (leave.startdate || 'N/A');
                    const endDate = isSpecific ? 'N/A' : (leave.enddate || 'N/A');
                    const specificDates = isSpecific && leave.specific_dates
                        ? leave.specific_dates.split(',').join('<br>')
                        : 'N/A';

                    leaveHtml += `<tr>
                        <td>${leave.leavetype}</td>
                        <td>${startDate}</td>
                        <td>${endDate}</td>
                        <td>${specificDates}</td>
                        <td>${leave.numofdays}</td>
                    </tr>`;
                });
            } else {
                leaveHtml = `<tr><td colspan="5" class="text-center">No leave history available</td></tr>`;
            }
            $("#leaveHistory").html(leaveHtml);


            // Travel History
            var travelHtml = "";
            if (response.travel.length > 0) {
                response.travel.forEach(function (travel) {
                    const specificDates = travel.specific_dates
                        ? travel.specific_dates.split(/[\n,]+/).map(date => date.trim()).filter(date => date).join('<br>')
                        : 'N/A';

                    const numOfDays = travel.numofdays ?? 'N/A';

                    travelHtml += `<tr>
                        <td>${travel.purpose}</td>
                        <td>${travel.destination}</td>
                        <td>${travel.startdate || 'N/A'}</td>
                        <td>${travel.enddate || 'N/A'}</td>
                        <td>${specificDates}</td>
                        <td>${numOfDays}</td>
                    </tr>`;
                });
            } else {
                travelHtml = `<tr><td colspan="6" class="text-center">No travel history available</td></tr>`;
            }
            $("#travelHistory").html(travelHtml);

        },
        error: function (xhr, status, error) {
            console.error("Failed to fetch history", xhr.responseText);
        }
    });

    console.log("Sending to fetch_history.php:", { employee_id, indexno });

    // Show the modal
    console.log("Sending to fetch_history.php:", { employee_id, indexno });

    // Reset visibility when modal opens
    $('#leaveHistoryWrapper').hide();
    $('#travelHistoryWrapper').hide();
    $('#toggleLeaveBtn').text('Show Leave History');
    $('#toggleTravelBtn').text('Show Travel History');

    // Show the modal
    $('#viewEmployeeModal').modal('show');

});

$(document).ready(function () {
    $('#toggleLeaveBtn').on('click', function () {
        $('#leaveHistoryWrapper').toggle();
        let text = $('#leaveHistoryWrapper').is(':visible') ? 'Hide Leave History' : 'Show Leave History';
        $(this).text(text);
    });

    $('#toggleTravelBtn').on('click', function () {
        $('#travelHistoryWrapper').toggle();
        let text = $('#travelHistoryWrapper').is(':visible') ? 'Hide Travel History' : 'Show Travel History';
        $(this).text(text);
    });
});

