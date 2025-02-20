function calculateNumberofDays() {
  const startDate = document.getElementById("startDate").value;
  const endDate = document.getElementById("endDate").value;

  if (startDate && endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    const timeDifference = end - start;
    const daysDifference = timeDifference / (1000 * 3600 * 24) + 1;

    if (daysDifference > 0) {
      document.getElementById('numberOfDays').value = daysDifference;
    } else {
      document.getElementById('startDate').value = '';
      document.getElementById('endDate').value = '';
      Swal.fire({
        title: "Invalid Dates",
        text: "End date should be greater than start date.",
        icon: "error"
      });
    }
  }
}