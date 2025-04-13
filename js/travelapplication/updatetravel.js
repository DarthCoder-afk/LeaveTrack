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
   var sdays = button.data('numdays');
   var form = button.data('file');
   var dateType = button.data('date_type'); // 'consecutive' or 'specific'
   var specificDates = button.data('specific_dates'); // Comma-separated specific dates
   
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
   modal.find('#dateApplied2').val(datefiled);
   modal.find('#startDate').val(sdate);
   modal.find('#endDate').val(edate);

   // Set the radio button for date type
   if (dateType === 'specific') {
      modal.find('input[name="date_type2"][value="specific"]').prop('checked', true);
      modal.find('#specificDatesContainer2').show();
      modal.find('#consecutiveDatesContainer2').hide();

      // Populate specific dates field
      modal.find('#specificDates2').val(specificDates);
      modal.find('#specificnumdays2').val(sdays);
  } else {
      modal.find('input[name="date_type2"][value="consecutive"]').prop('checked', true);
      modal.find('#specificDatesContainer2').hide();
      modal.find('#consecutiveDatesContainer2').show();

      // Populate consecutive dates fields
      modal.find('#startDate2').val(sdate);
      modal.find('#endDate2').val(edate);
      modal.find('#numberOfDays2').val(ndays);
  }

  // Event listener for changing date type
  modal.find('input[name="date_type"]').off('change').on('change', function () {
      if ($(this).val() === 'specific') {
          modal.find('#specificDatesContainer2').show();
          modal.find('#consecutiveDatesContainer2').hide();
      } else {
          modal.find('#specificDatesContainer2').hide();
          modal.find('#consecutiveDatesContainer2').show();
      }
  });

   
   modal.find('#numberOfDays').val(ndays);
   if (form === '') {
      modal.find('#updateLabel').text('No file uploaded');
   } else {
      modal.find('#updateLabel').text(form)
   }


});
