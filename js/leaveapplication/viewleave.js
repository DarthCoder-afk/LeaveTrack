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

    console.log("Data Retrieved:", {employee_id, lname, fname, position, office, leavetype});

    var fullName = lname + ", " + fname + " " + (extname ? extname + " " : "") + (midname ? midname : "");

    // Update Profile Section
    $('#profileIdNumber').text(employee_id);
    $('#fullName').text(fullName);


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
        $('#view_file').attr('href', '../uploads/' + file).text("View File");
    } else {
        $('#view_file').text("No file attached").removeAttr('href');
    }

    $('#viewLeaveModal').modal('show');
});
