$(document).ready(function () {
    $('.viewLeaveBtn').click(function () {
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

        var fullName = lname + ", " + fname + " " + (extname ? extname + " " : "") + (midname ? midname : "");

        $('#view_employee_id').text(employee_id);
        $('#view_name').text(fullName);
        $('#view_position').text(position);
        $('#view_office').text(office);
        $('#view_leavetype').text(leavetype);
        $('#view_dateapplied').text(dateapplied);
        $('#view_startdate').text(startdate);
        $('#view_enddate').text(enddate);
        $('#view_numdays').text(numdays);

        if (file) {
            $('#view_file').attr('href', '../uploads/' + file).text("View File");
        } else {
            $('#view_file').text("No file attached").removeAttr('href');
        }
    });
});
