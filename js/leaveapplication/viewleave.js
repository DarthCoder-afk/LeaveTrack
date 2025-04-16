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
    var gender = $(this).data('gender');
    var date_type = $(this).data('date_type');
    var specific_dates = $(this).data('specific_dates');

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
    if (gender && gender.toLowerCase() === "male") {
        profilePic.attr("src", "../img/male_profile.png");
    } else if (gender && gender.toLowerCase() === "female") {
        profilePic.attr("src", "../img/female_profile.png");
    } else {
        profilePic.attr("src", "../img/profile_app.jpg");
    }

    // Set general information
    $('#viewLastName').val(lname);
    $('#viewFirstName').val(fname);
    $('#viewPosition').val(position);
    $('#viewOffice').val(office);
    $('#viewTypeOfLeave').val(leavetype);
    $('#viewDateApplied').val(formatDate(dateapplied));

    $('#viewNumberOfDays').val(numdays);

    // Handle date types: specific vs consecutive
    if (date_type === 'specific') {
        $('#specificDatesGroup').removeClass('d-none');
        $('#consecutiveDatesGroup').addClass('d-none');
    
        if (specific_dates) {
            const datesArray = specific_dates.split(/[\n,]+/).map(function (date) {
                return formatDate(date.trim());
            });
            $('#viewSpecificDates').val(datesArray.join('\n'));
        } else {
            $('#viewSpecificDates').val('');
        }
    } else {
        $('#specificDatesGroup').addClass('d-none');
        $('#consecutiveDatesGroup').removeClass('d-none');  
        $('#viewStartDate').val(formatDate(startdate));  // formatted display
        $('#viewEndDate').val(formatDate(enddate));      // formatted display
    }

    // Handle file link button
    if (file && file !== "null") {
        $('#view_file_btn')
            .attr('href', '../uploads/' + file)
            .removeClass('d-none');
    } else {
        $('#view_file_btn').addClass('d-none');
    }

    $('#viewLeaveModal').modal('show');
});

// Format helper
function formatDate(dateString) {
    if (!dateString) return '';
    var date = new Date(dateString);
    if (isNaN(date)) return dateString;
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}
