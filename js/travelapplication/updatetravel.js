$('#EditTravelModal').on('show.bs.modal', function (event) {
   console.log("Modal show event triggered"); 
   var button = $(event.relatedTarget);
   var employee_id = button.data('employee_id');
   var indexno = button.data('indexno');
   var lname = button.data('lname');
   var fname = button.data('fname');
   var midname = button.data('midname');
   var extname = button.data('extname');
   var position = button.data('position');
   var offices = button.data('office');
   var gender = button.data('gender');
   var purpose = button.data('purpose');
   var destination = button.data('destination');
   var datefiled = button.data('dateapplied');
   var sdate = button.data('startdate');
   var edate = button.data('enddate');
   var ndays = button.data('numdays');
   var form = button.data('file');
   
   console.log("employee_id:", employee_id );
   console.log("indexno:", indexno );
   console.log("office:", offices );
   

   // Update the modal's content.
   var modal = $(this);
   modal.find('#index_no').val(indexno);
   modal.find('#idnumber').val(employee_id);
   modal.find('#lastName').val(lname);
   modal.find('#firstName').val(fname);
   modal.find('#middleName').val(midname);
   modal.find('#nameExtension').val(extname);
   modal.find('#position').val(position);
   modal.find('#office').val(offices);
   modal.find('#purpose').val(purpose);
   modal.find('#destination').val(destination);
   modal.find('#dateApplied').val(datefiled);
   modal.find('#startDate').val(sdate);
   modal.find('#endDate').val(edate);
   
   modal.find('#numberOfDays').val(ndays);
   if (form === '') {
      modal.find('#updateLabel').text('No file uploaded');
   } else {
      modal.find('#updateLabel').text(form)
   }


});
