document.getElementById("reportStartDate").addEventListener("change", function () {
    let startDate = this.value;
    let endDatePicker = document.getElementById("reportEndDate");

    // Set the minimum date for the end date picker
    endDatePicker.min = startDate;

    // Reset end date if it's before the new start date
    if (endDatePicker.value < startDate) {
        endDatePicker.value = startDate;
    }
});

document.getElementById("generateReportBtn").addEventListener("click", function () {
    let startDate = document.getElementById("reportStartDate").value;
    let endDate = document.getElementById("reportEndDate").value;

    console.log("Start Date:", startDate);
    console.log("End Date:", endDate);

    if (startDate.trim() && endDate.trim()) {
        let reportURL = `../function/leavefunctions/generateReportTravel.php?start=${startDate}&end=${endDate}`;
        console.log("Opening URL:", reportURL);

        // Reset the date pickers after clicking "Generate"
        setTimeout(() => {
            document.getElementById("reportStartDate").value = "";
            document.getElementById("reportEndDate").value = "";
            document.getElementById("reportEndDate").min = "";
        }, 1000); // Delays the reset to allow report generation

        // Open report
        window.location.href = reportURL;
    } else {
        alert("Please select a valid date range.");
    }
});
