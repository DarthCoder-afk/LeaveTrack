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

    console.log("Data Retrieved:", {employee_id, lname, fname, position, office, leavetype, gender});

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

    // Set values for the view modal (Read-Only)
    $('#viewLastName').val(lname);
    $('#viewFirstName').val(fname);
    $('#viewPosition').val(position);
    $('#viewOffice').val(office);
    $('#viewTypeOfLeave').val(leavetype);
    $('#viewDateApplied').val(dateapplied);
    $('#viewStartDate').val(startdate);
    $('#viewEndDate').val(enddate);
    $('#viewNumberOfDays').val(numdays);

    // Handle file link
    if (file && file !== "null") {
        $('#view_file')
            .attr('href', '../uploads/' + file)
            .attr('target', '_blank')
            .text("📂 View Document")
            .css({ "color": "#007bff", "font-weight": "bold", "cursor": "pointer" });
    } else {
        $('#view_file').text("No file attached").removeAttr('href').css({ "color": "gray" });
    }

    $('#viewLeaveModal').modal('show');
});
