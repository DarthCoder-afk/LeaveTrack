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
        var sdays = button.data('numdays');
        var form = button.data('file');
        var optional_leave_type = button.data('optional_leave_type') || '';
        var dateType = button.data('date_type'); // 'consecutive' or 'specific'
        var specificDates = button.data('specific_dates'); // Comma-separated specific dates

        console.log("Employee ID:", employee_id);
        console.log("Index No:", indexno);
        console.log("Leave Type:", leavetype);

        var modal = $(this);
        modal.find('#index_no').val(indexno);
        modal.find('#idnumber').val(employee_id);
        modal.find('#lastName2').val(lname);
        modal.find('#firstName2').val(fname);
        modal.find('#middleName2').val(midname);
        modal.find('#nameExtension2').val(extname);
        modal.find('#position2').val(position);
        modal.find('#office2').val(office);
        modal.find('#gender2').val(gender);
        modal.find('#hidden_gender').val(hidden_gender);
        modal.find('#dateApplied2').val(datefiled);
        modal.find('#startDate2').val(sdate);
        modal.find('#endDate2').val(edate);
        modal.find('#numberOfDays2').val(ndays);
        

        if (form === '') {
            modal.find('#updateLabel').text('No file uploaded');
        } else {
            modal.find('#updateLabel').text(form);
        }

        // Set the radio button for date type
        if (dateType === 'specific') {
            modal.find('input[name="date_type2"][value="specific"]').prop('checked', true);
            modal.find('#specificDatesContainer2').show();
            modal.find('#consecutiveDatesContainer2').hide();

            // Populate specific dates field
            modal.find('#specificDates2').val(specificDates);
            modal.find('#specificnumdays2').val(sdays);
        } else {
            modal.find('input[name="date_type2"][value="consecutive"]').prop('checked', true);
            modal.find('#specificDatesContainer2').hide();
            modal.find('#consecutiveDatesContainer2').show();

            // Populate consecutive dates fields
            modal.find('#startDate2').val(sdate);
            modal.find('#endDate2').val(edate);
        }

        // Event listener for changing date type
        modal.find('input[name="date_type"]').off('change').on('change', function () {
            if ($(this).val() === 'specific') {
                modal.find('#specificDatesContainer2').show();
                modal.find('#consecutiveDatesContainer2').hide();
            } else {
                modal.find('#specificDatesContainer2').hide();
                modal.find('#consecutiveDatesContainer2').show();
            }
        });

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
            leaveTypeDropdown.append('<option value="Force Leave">Force Leave</option>');
            leaveTypeDropdown.append('<option value="Optional">Others</option>');
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
            leaveTypeDropdown.append('<option value="Force Leave">Force Leave</option>');
            leaveTypeDropdown.append('<option value="Optional">Others</option>');
        } else {
            leaveTypeDropdown.append('<option value="Sick Leave">Sick Leave</option>');
            leaveTypeDropdown.append('<option value="Vacation Leave">Vacation Leave</option>');
        }

        // Set the selected leave type
        leaveTypeDropdown.val(leavetype.trim());
        if (leaveTypeDropdown.val() !== leavetype.trim()) {
            console.error("Leave type not found in dropdown:", leavetype);
            leaveTypeDropdown.find('option').each(function () {
                console.log("Option Value:", $(this).val());
            });
        }

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
