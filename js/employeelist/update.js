$(document).ready(function () {
    function toggleEditCustomOffice() {
        if ($('#editTypeOfOffice').val() === "optional") {
            $('#editCustomOfficeInput').show();
        } else {
            $('#editCustomOfficeInput').hide();
            $('#editCustomOfficeInput').val('');
        }
    }

    // When the edit modal is opened
    $('#editEmployeeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

        var index_no = button.data('index_no');
        var employee_id = button.data('employee_id');
        var hidden_employee_id = button.data('employee_id');
        var lname = button.data('lname');
        var fname = button.data('fname');
        var midname = button.data('midname');
        var extname = button.data('extname');
        var position = button.data('position');
        var office = button.data('office');
        var gender = button.data('gender');
        var status = button.data('status');

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
        var officeDropdown = modal.find('#editTypeOfOffice');
        if (officeDropdown.find('option[value="' + office + '"]').length > 0) {
            officeDropdown.val(office);
            $('#editCustomOfficeInput').hide();
            $('#editCustomOfficeInput').val('');
        } else {
            officeDropdown.val("optional");
            $('#editCustomOfficeInput').show();
            $('#editCustomOfficeInput').val(office);
        }

        // Handle status toggle
        var statusToggle = modal.find('#status');
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

        // Ensure the custom office input updates dynamically
        $('#editTypeOfOffice').on('change', toggleEditCustomOffice);
    });
});
