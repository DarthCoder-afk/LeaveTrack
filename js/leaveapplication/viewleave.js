$(document).on('click', '.viewLeaveBtn', function () {
    console.log("View button clicked!");

    var employee_id = $(this).data('employee_id');
    var lname = $(this).data('lname');
    var fname = $(this).data('fname');
    var midname = $(this).data('midname');
    var extname = $(this).data('extname');
    var position = $(this).data('position');
    var office = $(this).data('office');
    var leavetype = $(this).data('leavetype');
    var dateapplied = $(this).data('dateapplied');
    var startdate = $(this).data('startdate');
    var enddate = $(this).data('enddate');
    var numdays = $(this).data('numdays');
    var file = $(this).data('file');
    var gender = $(this).data('gender'); // Get gender
    var date_type = $(this).data('date_type'); // 'consecutive' or 'specific'
    var specific_dates = $(this).data('specific_dates'); // Comma-separated or multi-line

    console.log("Data Retrieved:", {
        employee_id, lname, fname, midname, extname, position, office,
        leavetype, dateapplied, startdate, enddate, numdays, file, gender,
        date_type, specific_dates
    });

    var fullName = lname + ", " + fname + " " + (extname ? extname + " " : "") + (midname ? midname : "");

    // Update Profile Section
    $('#profileIdNumber').text(employee_id);
    $('#fullName').text(fullName);

    // Change Profile Picture Based on Gender
    var profilePic = $("#profilePic");
    if (gender.toLowerCase() === "male") {
        profilePic.attr("src", "../img/male_profile.png");  // Set Male Profile
    } else if (gender.toLowerCase() === "female") {
        profilePic.attr("src", "../img/female_profile.png"); // Set Female Profile
    } else {
        profilePic.attr("src", "../img/profile_app.jpg"); // Default Profile
    }

    // Set general information
    $('#viewLastName').val(lname);
    $('#viewFirstName').val(fname);
    $('#viewPosition').val(position);
    $('#viewOffice').val(office);
    $('#viewTypeOfLeave').val(leavetype);
    $('#viewDateApplied').val(dateapplied);
    $('#viewNumberOfDays').val(numdays);

    // Handle date types: specific vs consecutive
    if (date_type === 'specific') {
        $('#specificDatesGroup').removeClass('d-none');
        $('#consecutiveDatesGroup').addClass('d-none');
        $('#viewSpecificDates').val(specific_dates);
    } else {
        $('#specificDatesGroup').addClass('d-none');
        $('#consecutiveDatesGroup').removeClass('d-none');
        $('#viewStartDate').val(startdate);
        $('#viewEndDate').val(enddate);
    }

    // Handle file link button
    if (file && file !== "null") {
        $('#view_file_btn')
            .attr('href', '../uploads/' + file)
            .removeClass('d-none'); // Show the button
    } else {
        $('#view_file_btn')
            .addClass('d-none'); // Hide the button if no file is available
    }

    $('#viewLeaveModal').modal('show');
});
