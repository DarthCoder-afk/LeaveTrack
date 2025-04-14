$(document).ready(function () {
    let triggerButton = null;

    // ========== Verify Modal ==========
    $('#verifyModal2').on('show.bs.modal', function (event) {
        triggerButton = $(event.relatedTarget); // Store the button that triggered the modal
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

                        // Wait for verifyModal2 to completely hide
                        $('#verifyModal2').on('hidden.bs.modal', function () {
                            $('#EditTravelModal')
                                .data('relatedTarget', triggerButton[0]) // pass the button manually
                                .modal('show');

                            $(this).off('hidden.bs.modal'); // prevent stacking
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

    // ========== Edit Travel Modal ==========
    $('#EditTravelModal').on('show.bs.modal', function (event) {
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
            purpose: button.data('purpose'),
            destination: button.data('destination'),
            datefiled: button.data('dateapplied'),
            sdate: button.data('startdate'),
            edate: button.data('enddate'),
            ndays: button.data('numdays'),
            sdays: button.data('numdays'),
            form: button.data('file'),
            dateType: button.data('date_type'), // 'consecutive' or 'specific'
            specificDates: button.data('specific_dates') // Comma-separated specific dates
        };

        console.log("Employee ID:", data.employee_id);
        console.log("Index No:", data.indexno);
        console.log("Office:", data.office);

        // Populate modal fields
        modal.find('#index_no').val(data.indexno);
        modal.find('#idnumber').val(data.employee_id);
        modal.find('#lastName').val(data.lname);
        modal.find('#firstName').val(data.fname);
        modal.find('#middleName').val(data.midname);
        modal.find('#nameExtension').val(data.extname);
        modal.find('#position').val(data.position);
        modal.find('#office').val(data.office);
        modal.find('#purpose').val(data.purpose);
        modal.find('#destination').val(data.destination);
        modal.find('#dateApplied2').val(data.datefiled);
        modal.find('#startDate2').val(data.sdate);
        modal.find('#endDate2').val(data.edate);
        modal.find('#numberOfDays2').val(data.ndays);

        // Handle uploaded file label
        if (!data.form) {
            modal.find('#updateLabel').text('No file uploaded');
        } else {
            modal.find('#updateLabel').text(data.form);
        }

        // Handle date type
        if (data.dateType === 'specific') {
            modal.find('input[name="date_type2"][value="specific"]').prop('checked', true);
            modal.find('#specificDatesContainer2').show();
            modal.find('#consecutiveDatesContainer2').hide();
            modal.find('#specificDates2').val(data.specificDates);
            modal.find('#specificnumdays2').val(data.sdays);
        } else {
            modal.find('input[name="date_type2"][value="consecutive"]').prop('checked', true);
            modal.find('#specificDatesContainer2').hide();
            modal.find('#consecutiveDatesContainer2').show();
        }

        // Toggle date type
        modal.find('input[name="date_type2"]').off('change').on('change', function () {
            if ($(this).val() === 'specific') {
                modal.find('#specificDatesContainer2').show();
                modal.find('#consecutiveDatesContainer2').hide();
            } else {
                modal.find('#specificDatesContainer2').hide();
                modal.find('#consecutiveDatesContainer2').show();
            }
        });
    });
});
