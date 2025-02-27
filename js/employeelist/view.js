$(document).on('click', '.viewEmployeeBtn', function () {
    console.log("View button clicked!");

    var employee_id = $(this).data('employee_id');
    var lname = $(this).data('lname');
    var fname = $(this).data('fname');
    var midname = $(this).data('midname');
    var extname = $(this).data('extname');
    var position = $(this).data('position');
    var office = $(this).data('office');
    var gender = $(this).data('gender'); // Get gender

    console.log("Data Retrieved:", {employee_id, lname, fname, office, gender});

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
    $('#view_employee_id').val(employee_id);
    $('#view_lname').val(lname);
    $('#view_fname').val(fname);
    $('#view_midname').val(midname);
    $('#view_extname').val(extname);
    $('#view_position').val(position);
    $('#view_office').val(office);
    $('#view_gender').val(gender);

    // Show the modal
    $('#viewEmployeeModal').modal('show');
});
