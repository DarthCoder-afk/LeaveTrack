$(document).ready(function () {
    $('#editLeaveModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var employee_id = button.data('employee_id');
        var indexno = button.data('indexno');
        var lname = button.data('lname');
        var fname = button.data('fname');
        var midname = button.data('midname');
        var extname = button.data('extname');
        var position = button.data('position');
        var office = button.data('office');
        var gender = button.data('gender');
        var hidden_gender = button.data('gender');
        var leavetype = button.data('leavetype');
        var datefiled = button.data('dateapplied');
        var sdate = button.data('startdate');
        var edate = button.data('enddate');
        var ndays = button.data('numdays');
        var form = button.data('file');
        var optional_leave_type = button.data('optional_leave_type') || '';

        console.log("Employee ID:", employee_id);
        console.log("Index No:", indexno);

        var modal = $(this);
        modal.find('#index_no').val(indexno);
        modal.find('#idnumber').val(employee_id);
        modal.find('#lastName').val(lname);
        modal.find('#firstName').val(fname);
        modal.find('#middleName').val(midname);
        modal.find('#nameExtension').val(extname);
        modal.find('#position').val(position);
        modal.find('#office').val(office);
        modal.find('#gender').val(gender);
        modal.find('#hidden_gender').val(hidden_gender);
        modal.find('#dateApplied').val(datefiled);
        modal.find('#startDate2').val(sdate);
        modal.find('#endDate2').val(edate);
        modal.find('#numberOfDays2').val(ndays);

        if (form === '') {
            modal.find('#updateLabel').text('No file uploaded');
        } else {
            modal.find('#updateLabel').text(form);
        }

        var leaveTypeDropdown = modal.find('#typeOfLeave');
        var optionalLeaveDiv = modal.find('#optionalLeaveDiv');
        var optionalLeaveInput = modal.find('#optionalLeaveType');

        leaveTypeDropdown.empty();
        leaveTypeDropdown.append('<option value="" disabled>Select Type of Leave</option>');

        if (hidden_gender === 'Male') {
            leaveTypeDropdown.append('<option value="Vacation Leave">Vacation Leave</option>');
            leaveTypeDropdown.append('<option value="Mandatory/Forced Leave">Mandatory/Forced Leave</option>');
            leaveTypeDropdown.append('<option value="Sick Leave">Sick Leave</option>');
            leaveTypeDropdown.append('<option value="Paternity Leave">Paternity Leave</option>');
            leaveTypeDropdown.append('<option value="Special Privilege Leave">Special Privilege Leave</option>');
            leaveTypeDropdown.append('<option value="Solo Parent Leave">Solo Parent Leave</option>');
            leaveTypeDropdown.append('<option value="Study Leave">Study Leave</option>');
            leaveTypeDropdown.append('<option value="Rehabilitation Leave">Rehabilitation Leave</option>');
            leaveTypeDropdown.append('<option value="Special (Calamity) Leave">Special (Calamity) Leave</option>');
            leaveTypeDropdown.append('<option value="Monetization">Monetization</option>');
            leaveTypeDropdown.append('<option value="Optional">Optional</option>');
        } else if (hidden_gender === 'Female') {
            leaveTypeDropdown.append('<option value="Vacation Leave">Vacation Leave</option>');
            leaveTypeDropdown.append('<option value="Mandatory/Forced Leave">Mandatory/Forced Leave</option>');
            leaveTypeDropdown.append('<option value="Sick Leave">Sick Leave</option>');
            leaveTypeDropdown.append('<option value="Maternity Leave">Maternity Leave</option>');
            leaveTypeDropdown.append('<option value="Special Privilege Leave">Special Privilege Leave</option>');
            leaveTypeDropdown.append('<option value="Solo Parent Leave">Solo Parent Leave</option>');
            leaveTypeDropdown.append('<option value="Study Leave">Study Leave</option>');
            leaveTypeDropdown.append('<option value="10-Day VAWC Leave">10-Day VAWC Leave</option>');
            leaveTypeDropdown.append('<option value="Rehabilitation Leave">Rehabilitation Leave</option>');
            leaveTypeDropdown.append('<option value="Special Leave Benefits for Women">Special Leave Benefits for Women</option>');
            leaveTypeDropdown.append('<option value="Special (Calamity) Leave">Special (Calamity) Leave</option>');
            leaveTypeDropdown.append('<option value="Monetization">Monetization</option>');
            leaveTypeDropdown.append('<option value="Optional">Optional</option>');
        } else {
            leaveTypeDropdown.append('<option value="Sick Leave">Sick Leave</option>');
            leaveTypeDropdown.append('<option value="Vacation Leave">Vacation Leave</option>');
        }

        // Set the selected leave type
        leaveTypeDropdown.val(leavetype);

        // Handle showing/hiding optional leave input
        if (leavetype === "Optional") {
            optionalLeaveDiv.show();
            optionalLeaveInput.val(optional_leave_type);
            optionalLeaveInput.prop('required', true);
        } else {
            optionalLeaveDiv.hide();
            optionalLeaveInput.val('');
            optionalLeaveInput.prop('required', false);
        }

        // Event listener for changing leave type
        leaveTypeDropdown.off('change').on('change', function () {
            if ($(this).val() === "Optional") {
                optionalLeaveDiv.show();
                optionalLeaveInput.prop('required', true);
            } else {
                optionalLeaveDiv.hide();
                optionalLeaveInput.val('');
                optionalLeaveInput.prop('required', false);
            }
        });
    });
});
