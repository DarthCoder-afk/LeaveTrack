function calculateNumberofDays() {
  const startDate = document.getElementById("startDate").value;
  const endDate = document.getElementById("endDate").value;

  if (startDate && endDate) {
    let start = new Date(startDate);
    let end = new Date(endDate);
    
    if (end < start) {
      document.getElementById('startDate').value = '';
      document.getElementById('endDate').value = '';
      Swal.fire({
        title: "Invalid Dates",
        text: "End date should be greater than start date.",
        icon: "error"
      });
      return;
    }

    let weekdays = 0;
    let currentDate = new Date(start);

    while (currentDate <= end) {
      let dayOfWeek = currentDate.getDay();
      if (dayOfWeek !== 6 && dayOfWeek !== 0) { // Exclude Saturday (6) and Sunday (0)
        weekdays++;
      }
      currentDate.setDate(currentDate.getDate() + 1);
    }

    document.getElementById('numberOfDays').value = weekdays;
  }
}
