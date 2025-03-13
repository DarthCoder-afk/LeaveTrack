function debounce(func, wait) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}

document.getElementById('idnumber').addEventListener('input', debounce(function() {
    var employeeId = this.value;

    if (employeeId) {
        console.log('Employee ID entered:', employeeId);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../function/details/employee_details.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    console.log('Response:', response);
                    if (response && !response.error) {
                        document.getElementById('emp_index').value = response.indexno || '';
                        document.getElementById('lastName').value = response.lname || '';
                        document.getElementById('firstName').value = response.fname || '';
                        document.getElementById('middleName').value = response.midname || '';
                        document.getElementById('gender').value = response.gender || '';
                        document.getElementById('hidden_gender').value = response.gender || '';
                        document.getElementById('nameExtension').value = response.extname || '';
                        document.getElementById('position').value = response.position || '';
                        document.getElementById('office').value = response.office || '';

                        var modal = $('#addApplicationForm');
                        modal.find('#hidden_gender').val(response.gender || '');

                        var leaveTypeDropdown = modal.find('#typeOfLeave');
                        leaveTypeDropdown.empty();

                        leaveTypeDropdown.append('<option value="" disabled selected>Select Type of Leave</option>');
                        if (response.gender === 'Male') {
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
                        } else if (response.gender === 'Female') {
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
                        } else {
                            leaveTypeDropdown.append('<option value="Sick Leave">Sick Leave</option>');
                            leaveTypeDropdown.append('<option value="Vacation Leave">Vacation Leave</option>');
                        }
                        leaveTypeDropdown.append('<option value="Optional">Optional</option>');
                    } else {
                        clearFields();
                        Swal.fire({
                            title: 'Employee not found',
                            text: response.error || 'No additional information available.',
                            icon: 'error',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                } else {
                    clearFields();
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while processing the request.',
                        icon: 'error',
                        timer: 1000,
                        showConfirmButton: false
                    });
                }
            }
        };
        xhr.send('employee_id=' + encodeURIComponent(employeeId));
    }
}, 1000));

function clearFields() {
    document.getElementById('idnumber').value = '';
    document.getElementById('emp_index').value = '';
    document.getElementById('lastName').value = '';
    document.getElementById('firstName').value = '';
    document.getElementById('middleName').value = '';
    document.getElementById('gender').value = '';
    document.getElementById('hidden_gender').value = '';
    document.getElementById('nameExtension').value = '';
    document.getElementById('position').value = '';
    document.getElementById('office').value = '';
}

document.getElementById('typeOfLeave').addEventListener('change', function() {
    var optionalLeaveContainer = document.getElementById('optionalLeaveContainer');
    var optionalLeaveInput = document.getElementById('optionalLeaveInput');

    if (this.value === 'Optional') {
        optionalLeaveContainer.style.display = 'block';
        optionalLeaveInput.required = true;
    } else {
        optionalLeaveContainer.style.display = 'none';
        optionalLeaveInput.required = false;
        optionalLeaveInput.value = '';
    }
});
