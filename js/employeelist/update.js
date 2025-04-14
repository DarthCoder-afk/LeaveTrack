$(document).ready(function () {
    let triggerButton = null;

    // ========== Toggle Custom Office Input ==========
    function toggleEditCustomOffice() {
        if ($('#editTypeOfOffice').val() === "optional") {
            $('#editCustomOfficeInput').show();
        } else {
            $('#editCustomOfficeInput').hide();
            $('#editCustomOfficeInput').val('');
        }
    }

    // ========== Verify Modal Logic ==========
    $('#verifyModal2').on('show.bs.modal', function (event) {
        triggerButton = $(event.relatedTarget); // Button that triggered verification
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

                        // After hiding verifyModal3, show editEmployeeModal
                        $('#verifyModal2').on('hidden.bs.modal', function () {
                            $('#editEmployeeModal')
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

    // ========== Edit Employee Modal Logic ==========
    $('#editEmployeeModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget || $(this).data('relatedTarget'));
        const modal = $(this);

        const index_no = button.data('index_no');
        const employee_id = button.data('employee_id');
        const hidden_employee_id = button.data('employee_id');
        const lname = button.data('lname');
        const fname = button.data('fname');
        const midname = button.data('midname');
        const extname = button.data('extname');
        const position = button.data('position');
        const office = button.data('office');
        const gender = button.data('gender');
        const status = button.data('status');

        // Populate fields
        modal.find('#index_no').val(index_no);
        modal.find('#idnumber').val(employee_id);
        modal.find('#hidden_id').val(hidden_employee_id);
        modal.find('#lastName').val(lname);
        modal.find('#firstName').val(fname);
        modal.find('#middleName').val(midname);
        modal.find('#nameExtension').val(extname);
        modal.find('#position').val(position);
        modal.find('#typeOfGender').val(gender);

        // Handle Office Selection
        const officeDropdown = modal.find('#editTypeOfOffice');
        if (officeDropdown.find(`option[value="${office}"]`).length > 0) {
            officeDropdown.val(office);
            $('#editCustomOfficeInput').hide().val('');
        } else {
            officeDropdown.val("optional");
            $('#editCustomOfficeInput').show().val(office);
        }

        // Handle status toggle
        const statusToggle = modal.find('#status');
        if (statusToggle.length) {
            statusToggle.bootstrapToggle({
                on: 'Active',
                off: 'Inactive',
                onstyle: 'success',
                offstyle: 'danger'
            });

            if (status === 'Active') {
                statusToggle.bootstrapToggle('on');
            } else {
                statusToggle.bootstrapToggle('off');
            }
        }

        // Dynamic update of office type
        $('#editTypeOfOffice').off('change').on('change', toggleEditCustomOffice);
    });
});
