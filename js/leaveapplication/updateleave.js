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
    

    console.log("employee id:", employee_id);
    console.log("index no:", indexno);

    // Update the modal's content.
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
     modal.find('#typeOfLeave').val(leavetype);
     modal.find('#dateApplied').val(datefiled);
     modal.find('#startDate').val(sdate);
     modal.find('#endDate').val(edate);
     modal.find('#numberOfDays').val(ndays);

     if (form === '') {
        modal.find('#updateLabel').text('No file uploaded');
     } else {
        modal.find('#updateLabel').text(form)
     }

     var leaveTypeDropdown = modal.find('#typeOfLeave');
    leaveTypeDropdown.empty(); // Clear existing options

    if (hidden_gender === 'Male') {
        leaveTypeDropdown.append('<option value="" disabled selected>Select Type of Leave</option>');
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
        
    } else if (hidden_gender === 'Female') {
        leaveTypeDropdown.append('<option value="" disabled selected>Select Type of Leave</option>');
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
    leaveTypeDropdown.val(leavetype);
  });