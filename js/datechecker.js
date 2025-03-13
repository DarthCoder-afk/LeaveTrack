function calculateNumberofDays() {
  var startDate = document.getElementById('startDate').value;
  var endDate = document.getElementById('endDate').value;
  var appliedDate = document.getElementById('dateApplied').value;
  var holidayDeduction = parseInt(document.getElementById('holidayDeduction').value) || 0;

  
  var startDateInput = document.getElementById('startDate');
  var endDateInput = document.getElementById('endDate');
  
  if (appliedDate) {
    // Enable start and end date inputs if applied date if provided
    startDateInput.disabled = false;
    endDateInput.disabled = false;
    // Disable past days, months, and years on start date and end date based on applied date
    startDateInput.min = appliedDate;
    endDateInput.min = appliedDate;
  }

  if (startDate && endDate) {
      var start = new Date(startDate);
      var end = new Date(endDate);
      var totalDays = 0;

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
  var holidayDeduction = parseInt(document.getElementById('updateholidayDeduction').value) || 0;

  if (startDate && endDate) {
      var start = new Date(startDate);
      var end = new Date(endDate);
      var totalDays = 0;

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
