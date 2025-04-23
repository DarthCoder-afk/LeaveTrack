$(document).ready(function () {
    let triggerButton = null;

    // ========== Verify Modal ==========
    $('#verifyModal2').on('show.bs.modal', function (event) {
        triggerButton = $(event.relatedTarget);
        $('#verifyPassword2').val('');

        $('#verifyForm2').off('submit').on('submit', function (e) {
            e.preventDefault();
            const password = $('#verifyPassword2').val();

            $.ajax({
                url: '../auth/verify.php',
                type: 'POST',
                data: { password: password },
                success: function (response) {
                    const jsonResponse = JSON.parse(response);

                    if (jsonResponse.success) {
                        $('#verifyModal2').modal('hide');

                        $('#verifyModal2').on('hidden.bs.modal', function () {
                            $('#editLeaveModal')
                                .data('relatedTarget', triggerButton[0])
                                .modal('show');

                            $(this).off('hidden.bs.modal');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Incorrect Password!',
                            text: 'The password you entered is incorrect. Please try again.',
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred. Please try again later.'
                    });
                }
            });
        });
    });

    // ========== Edit Leave Modal ==========
    $('#editLeaveModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget || $(this).data('relatedTarget'));
        const modal = $(this);

        const data = {
            employee_id: button.data('employee_id'),
            indexno: button.data('indexno'),
            lname: button.data('lname'),
            fname: button.data('fname'),
            midname: button.data('midname'),
            extname: button.data('extname'),
            position: button.data('position'),
            office: button.data('office'),
            gender: button.data('gender'),
            leavetype: button.data('leavetype'),
            dateapplied: button.data('dateapplied'),
            startdate: button.data('startdate'),
            enddate: button.data('enddate'),
            numdays: button.data('numdays'),
            file: button.data('file'),
            dateType: button.data('date_type'),
            specificDates: button.data('specific_dates'),
            optional_leave_type: button.data('optional_leave_type') || ''
        };

        modal.find('#index_no').val(data.indexno);
        modal.find('#idnumber').val(data.employee_id);
        modal.find('#lastName2').val(data.lname);
        modal.find('#firstName2').val(data.fname);
        modal.find('#middleName2').val(data.midname);
        modal.find('#nameExtension2').val(data.extname);
        modal.find('#position2').val(data.position);
        modal.find('#office2').val(data.office);
        modal.find('#gender2').val(data.gender);
        modal.find('#hidden_gender').val(data.gender);
        modal.find('#dateApplied2').val(data.dateapplied);
        modal.find('#startDate2').val(data.startdate);
        modal.find('#endDate2').val(data.enddate);

        modal.find('#updateLabel').text(data.file === '' ? 'No file uploaded' : data.file);

        if (data.dateType === 'specific') {
            modal.find('input[name="date_type2"][value="specific"]').prop('checked', true);
            modal.find('#specificDatesContainer2').show();
            modal.find('#consecutiveDatesContainer2').hide();
            modal.find('#specificDates2').val(data.specificDates);
            modal.find('#specificnumdays2').val(data.numdays);
        } else {
            modal.find('input[name="date_type2"][value="consecutive"]').prop('checked', true);
            modal.find('#specificDatesContainer2').hide();
            modal.find('#consecutiveDatesContainer2').show();
            modal.find('#numberOfDays2').val(data.numdays);
        }

        modal.find('input[name="date_type2"]').off('change').on('change', function () {
            const val = $(this).val();
            modal.find('#specificDatesContainer2').toggle(val === 'specific');
            modal.find('#consecutiveDatesContainer2').toggle(val !== 'specific');
        });

        const leaveTypeDropdown = modal.find('#typeOfLeave');
        const optionalLeaveDiv = modal.find('#optionalLeaveDiv');
        const optionalLeaveInput = modal.find('#optionalLeaveType');

        leaveTypeDropdown.empty().append(`
            <option value="" disabled>Select Type of Leave</option>
        `);

        const optionsMale = [
            "Vacation Leave", "Mandatory/Forced Leave", "Sick Leave", "Paternity Leave", "Special Privilege Leave",
            "Solo Parent Leave", "Study Leave", "Rehabilitation Leave", "Special (Calamity) Leave",
            "Monetization", "Force Leave", "Optional"
        ];
        const optionsFemale = [
            "Vacation Leave", "Mandatory/Forced Leave", "Sick Leave", "Maternity Leave", "Special Privilege Leave",
            "Solo Parent Leave", "Study Leave", "10-Day VAWC Leave", "Rehabilitation Leave",
            "Special Leave Benefits for Women", "Special (Calamity) Leave", "Monetization", "Force Leave", "Optional"
        ];

        const options = data.gender === 'Male' ? optionsMale :
                        data.gender === 'Female' ? optionsFemale :
                        ["Sick Leave", "Vacation Leave", "Optional"];

        options.forEach(type => {
            leaveTypeDropdown.append(`<option value="${type}">${type}</option>`);
        });

        const normalizedLeaveType = data.leavetype?.trim().toLowerCase() || '';
        const matchedLeaveType = options.find(opt => opt.toLowerCase() === normalizedLeaveType);

        if (matchedLeaveType) {
            leaveTypeDropdown.val(matchedLeaveType);
            const isOptional = matchedLeaveType.toLowerCase() === "optional";
            optionalLeaveDiv.toggle(isOptional);
            optionalLeaveInput.prop('required', isOptional).val(isOptional ? data.optional_leave_type : '');
        } else {
            // If not matched, assume it's a custom optional type
            leaveTypeDropdown.val("Optional");
            optionalLeaveDiv.show();
            optionalLeaveInput.prop('required', true).val(data.leavetype);
        }

        leaveTypeDropdown.off('change').on('change', function () {
            const selected = $(this).val();
            const isOptional = selected.toLowerCase() === "optional";
            optionalLeaveDiv.toggle(isOptional);
            optionalLeaveInput.prop('required', isOptional);

            if (!isOptional) {
                optionalLeaveInput.val('');
            } else {
                optionalLeaveInput.val(data.optional_leave_type || data.leavetype || '');
            }
        });
    });
});
