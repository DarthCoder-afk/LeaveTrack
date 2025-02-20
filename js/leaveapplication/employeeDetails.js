document.getElementById('idnumber').addEventListener('change', function() {
    var employeeId = this.value;

    if (employeeId) {
        console.log('Employee ID entered:', employeeId);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../function/leavefunctions/employee_details.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    console.log('Response:', response);
                    if (response && !response.error) {
                        document.getElementById('lastName').value = response.lname || '';
                        document.getElementById('firstName').value = response.fname || '';
                        document.getElementById('middleName').value = response.midname || '';
                        document.getElementById('gender').value = response.gender || '';
                        document.getElementById('nameExtension').value = response.extname || '';
                        document.getElementById('position').value = response.position || '';
                        document.getElementById('office').value = response.office || '';
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
});

function clearFields() {
    document.getElementById('idnumber').value = '';
    document.getElementById('lastName').value = '';
    document.getElementById('firstName').value = '';
    document.getElementById('middleName').value = '';
    document.getElementById('gender').value = '';
    document.getElementById('nameExtension').value = '';
    document.getElementById('position').value = '';
    document.getElementById('office').value = '';
}