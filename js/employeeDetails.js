function updateDropdown() {
    var gender = document.getElementById('hidden_gender').value;
    console.log('Selected Gender:', gender);  // Debugging log

    var typeOfLeave = document.getElementById('typeOfLeave');
    typeOfLeave.innerHTML = '';

    var options = {
        'Male': [
            { value: '', text: 'Select Type of Leave' },
            { value: 'Vacation Leave', text: 'Vacation Leave' },
            { value: 'Mandatory/Forced Leave', text: 'Mandatory/Forced Leave' },
            { value: 'Sick Leave', text: 'Sick Leave' },
            { value: 'Paternity Leave', text: 'Paternity Leave' },
            { value: 'Special Privilege Leave', text: 'Special Privilege Leave' },
            { value: 'Solo Parent Leave', text: 'Solo Parent Leave' },
            { value: 'Study Leave', text: 'Study Leave' },
            { value: 'Rehabilitation Privilege', text: 'Rehabilitation Privilege' },
            { value: 'Special Emergency (Calamity) Leave', text: 'Special Emergency (Calamity) Leave' },
            { value: 'Adoption Leave', text: 'Adoption Leave' },
            { value: 'Monetization', text: 'Monetization' }
        ],
        'Female': [
            { value: '', text: 'Select Type of Leave' },
            { value: 'Vacation Leave', text: 'Vacation Leave' },
            { value: 'Mandatory/Forced Leave', text: 'Mandatory/Forced Leave' },
            { value: 'Sick Leave', text: 'Sick Leave' },
            { value: 'Maternity Leave', text: 'Maternity Leave' },
            { value: 'Special Privilege Leave', text: 'Special Privilege Leave' },
            { value: 'Solo Parent Leave', text: 'Solo Parent Leave' },
            { value: 'Study Leave', text: 'Study Leave' },
            { value: '10-Day VAWC Leave', text: '10-Day VAWC Leave' },
            { value: 'Rehabilitation Privilege', text: 'Rehabilitation Privilege' },
            { value: 'Special Leave Benefits for Women', text: 'Special Leave Benefits for Women' },
            { value: 'Special Emergency (Calamity) Leave', text: 'Special Emergency (Calamity) Leave' },
            { value: 'Adoption Leave', text: 'Adoption Leave' },
            { value: 'Monetization', text: 'Monetization' }
        ]
    };

    // Populate the dropdown
    options[gender].forEach(function(option) {
        var newOption = document.createElement('option');
        newOption.value = option.value;  // This is the value sent to the database
        newOption.textContent = option.text;
        typeOfLeave.appendChild(newOption);
    });
}




function debounce(func, wait) {
    let timeout;
    return function(...args){
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(()=> func.apply(context,args), wait);
    };
}


document.getElementById('idnumber').addEventListener('input', debounce(function(){
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
                        document.getElementById('lastName').value = response.lname || '';
                        document.getElementById('firstName').value = response.fname || '';
                        document.getElementById('middleName').value = response.midname || '';
                        document.getElementById('gender').value = response.gender || '';
                        document.getElementById('hidden_gender').value = response.gender|| '';
                        document.getElementById('nameExtension').value = response.extname || '';
                        document.getElementById('position').value = response.position || '';
                        document.getElementById('office').value = response.office || '';

                        updateDropdown();
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
}, 550));  //delay

function clearFields() {
    document.getElementById('idnumber').value = '';
    document.getElementById('lastName').value = '';
    document.getElementById('firstName').value = '';
    document.getElementById('middleName').value = '';
    document.getElementById('gender').value = '';
    document.getElementById('hidden_gender').value = '';
    document.getElementById('nameExtension').value = '';
    document.getElementById('position').value = '';
    document.getElementById('office').value = '';
}