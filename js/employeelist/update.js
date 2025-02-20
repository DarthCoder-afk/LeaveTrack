$('#editEmployeeModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var employee_id = button.data('employee_id');
    var lname = button.data('lname');
    var fname = button.data('fname');
    var midname = button.data('midname');
    var extname = button.data('extname');
    var position = button.data('position');
    var office = button.data('office');
    var gender = button.data('gender')

    console.log("employee id:", employee_id);

    // Update the modal's content.
    var modal = $(this);
     modal.find('#idnumber').val(employee_id);
     modal.find('#lastName').val(lname);
     modal.find('#firstName').val(fname);
     modal.find('#middleName').val(midname);
     modal.find('#nameExtension').val(extname);
     modal.find('#position').val(position);
     modal.find('#typeOfOffice').val(office);
     modal.find('#typeOfGender').val(gender);
  });