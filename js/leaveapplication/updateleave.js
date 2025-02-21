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
     modal.find('#typeOfLeave').val(leavetype);
     modal.find('#dateApplied').val(datefiled);
     modal.find('#startDate').val(sdate);
     modal.find('#endDate').val(edate);
     modal.find('#numberOfDays').val(ndays);
     modal.find('#formFilename').text(form);
  });