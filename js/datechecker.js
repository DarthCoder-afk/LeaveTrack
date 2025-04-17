// Multiple Dates Selection
document.addEventListener('DOMContentLoaded', function () {
  flatpickr("#specificDates", {
    mode: "multiple", // Allows multiple date selection
    dateFormat: "Y-m-d", // Format for the selected dates
    onChange: function(selectedDates, dateStr, instance) {
      // Optional: Update the number of days based on selected dates
      document.getElementById('specificnumdays').value = selectedDates.length;
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {
  flatpickr("#specificDates2", {
    mode: "multiple", // Allows multiple date selection
    dateFormat: "Y-m-d", // Format for the selected dates
    onChange: function(selectedDates, dateStr, instance) {
      // Optional: Update the number of days based on selected dates
      document.getElementById('specificnumdays2').value = selectedDates.length;
    }
  });
});

// Function for date type (Consecutive or Specific)
function toggleDateType() {
  const dateType = document.querySelector('input[name="date_type"]:checked').value;
  const consecutiveDates = document.getElementById('consecutiveDatesContainer');
  const specificDates = document.getElementById('specificDatesContainer');

  if (dateType === 'consecutive') {
    consecutiveDates.style.display = 'flex';
    specificDates.style.display = 'none';
    // Clear specific dates input
    document.getElementById('specificDates').value = '';
    document.getElementById('specificnumdays').value = '';
  } else {
    consecutiveDates.style.display = 'none';
    specificDates.style.display = 'flex';

    // Clear consecutive dates input
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';
    document.getElementById('numberOfDays').value = '';
  }
}

function toggleDateType2() {
  const dateType = document.querySelector('input[name="date_type2"]:checked').value;
  const consecutiveDates = document.getElementById('consecutiveDatesContainer2');
  const specificDates = document.getElementById('specificDatesContainer2');

  if (dateType === 'consecutive') {
    consecutiveDates.style.display = 'flex';
    specificDates.style.display = 'none';

    // Clear specific dates input
    document.getElementById('specificDates2').value = '';
    document.getElementById('specificnumdays2').value = '';
  } else {
    consecutiveDates.style.display = 'none';
    specificDates.style.display = 'flex';

     // Clear consecutive dates input
    document.getElementById('startDate2').value = '';
    document.getElementById('endDate2').value = '';
    document.getElementById('numberOfDays2').value = '';
  }
}

function calculateNumberofDays() {
  var startDate = document.getElementById('startDate').value;
  var endDate = document.getElementById('endDate').value;
  var appliedDate = document.getElementById('dateApplied').value;
  var holidayDeduction = parseInt(document.getElementById('holidayDeduction').value) || 0;
  var startDateInput = document.getElementById('startDate');
  var endDateInput = document.getElementById('endDate');

  console.log("Start Date:", startDate);
  console.log("End Date:", endDate);
  console.log("Applied Date:", appliedDate);
  
  if (appliedDate) {

    // Disable past days, months, and years on start date and end date based on applied date
    startDateInput.min = appliedDate;
    endDateInput.min = appliedDate;
  } 

   // Validate end date independently
   if (endDate && !startDate) {
    Swal.fire({
      title: "Invalid Input",
      text: "Please select a start date before selecting an end date.",
      icon: "warning"
    });
    endDateInput.value = ''; // Clear the invalid end date
    return;
  }

  if (startDate && endDate) {
      var start = new Date(startDate);
      var end = new Date(endDate);
      var totalDays = 0;

      // If end date is less than start date returns error
      if (end < start) {
        Swal.fire({
          title: "Invalid Dates",
          text: "End date should be greater than start date.",
          icon: "error"
        });
        endDateInput.value = '';
      }
      

      // Loop through each day and count only weekdays
      for (var d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
          var dayOfWeek = d.getDay();
          if (dayOfWeek !== 6 && dayOfWeek !== 0) { // Exclude Saturday (6) and Sunday (0)
              totalDays++;
          }
      }

      // Ensure holiday deduction does not exceed total days
      if (holidayDeduction > totalDays) {
          holidayDeduction = totalDays;
          document.getElementById('holidayDeduction').value = totalDays;
      }

      var finalDays = totalDays - holidayDeduction;
      document.getElementById('numberOfDays').value = finalDays;
  }
}

// Toggle holiday input visibility
document.getElementById('toggleHolidayInput').addEventListener('click', function() {
  var holidayContainer = document.getElementById('holidayContainer');
  holidayContainer.style.display = (holidayContainer.style.display === 'none') ? 'block' : 'none';
});

function UpdatecalculateNumberofDays() {
  var startDate = document.getElementById('startDate2').value;
  var endDate = document.getElementById('endDate2').value;
  var appliedDate = document.getElementById('dateApplied2').value;
  var startDateInput = document.getElementById('startDate2');
  var endDateInput = document.getElementById('endDate2');
  var holidayDeduction = parseInt(document.getElementById('updateholidayDeduction').value) || 0;

  if (appliedDate) {
    // Disable past days, months, and years on start date and end date based on applied date
    startDateInput.min = appliedDate;
    endDateInput.min = appliedDate;
  } 

  if (startDate && endDate) {
      var start = new Date(startDate);
      var end = new Date(endDate);
      var totalDays = 0;

      // If end date is less than start date returns error
      if (end < start) {
        Swal.fire({
          title: "Invalid Dates",
          text: "End date should be greater than start date.",
          icon: "error"
        });
        endDateInput.value = '';
      }

      // Loop through each day and count only weekdays
      for (var d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
          var dayOfWeek = d.getDay();
          if (dayOfWeek !== 6 && dayOfWeek !== 0) { // Exclude Saturday (6) and Sunday (0)
              totalDays++;
          }
      }

      // Ensure holiday deduction does not exceed total days
      if (holidayDeduction > totalDays) {
          holidayDeduction = totalDays;
          document.getElementById('updateholidayDeduction').value = totalDays;
      }

      var finalDays = totalDays - holidayDeduction;
      document.getElementById('numberOfDays2').value = finalDays;
  }
}

// Toggle holiday input visibility
document.getElementById('updatetoggleHolidayInput').addEventListener('click', function() {
  var holidayContainer = document.getElementById('updateholidayContainer');
  holidayContainer.style.display = (holidayContainer.style.display === 'none') ? 'block' : 'none';
});
