$(document).on('click', '.viewEmployeeBtn', function () {
    console.log("View button clicked!");

    var employee_id = $(this).data('employee_id');
    var lname = $(this).data('lname');
    var fname = $(this).data('fname');
    var midname = $(this).data('midname');
    var extname = $(this).data('extname');
    var position = $(this).data('position');
    var office = $(this).data('office');
    var gender = $(this).data('gender');

    console.log("Data Retrieved:", { employee_id, lname, fname, office, gender });

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
    
    // Fetch Leave & Travel History
    $.ajax({
        url: '../function/employeefunction/fetch_history.php',
        type: 'POST',
        data: { employee_id: employee_id },
        dataType: 'json',
        success: function (response) {
            // Leave History
            var leaveHtml = "";
            if (response.leave.length > 0) {
                response.leave.forEach(function (leave) {
                    leaveHtml += `<tr>
                        <td>${leave.leavetype}</td>
                        <td>${leave.start_date}</td>
                        <td>${leave.end_date}</td>
                        <td>${leave.numofdays}</td>
                    </tr>`;
                });
            } else {
                leaveHtml = `<tr><td colspan="4" class="text-center">No leave history available</td></tr>`;
            }
            $("#leaveHistory").html(leaveHtml);

            // Travel History
            var travelHtml = "";
            if (response.travel.length > 0) {
                response.travel.forEach(function (travel) {
                    travelHtml += `<tr>
                        <td>${travel.destination}</td>
                        <td>${travel.stardate}</td>
                        <td>${travel.enddate}</td>
                        <td>${travel.purpose}</td>
                    </tr>`;
                });
            } else {
                travelHtml = `<tr><td colspan="4" class="text-center">No travel history available</td></tr>`;
            }
            $("#travelHistory").html(travelHtml);
        },
        error: function () {
            console.error("Failed to fetch history");
        }
    });

    // Show the modal
    $('#viewEmployeeModal').modal('show');
});

