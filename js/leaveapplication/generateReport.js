document.getElementById("generateReportBtn").addEventListener("click", function () {
    let startDate = document.getElementById("reportStartDate").value;
    let endDate = document.getElementById("reportEndDate").value;

    console.log("Start Date:", startDate);
    console.log("End Date:", endDate);
    $('#reportModal').on('shown.bs.modal', function () {
        console.log("Report modal opened!");
    });
    

    if (startDate.trim() && endDate.trim()) {
        let reportURL = `../function/leavefunctions/generateReport.php?start=${startDate}&end=${endDate}`;
        console.log("Opening URL:", reportURL);
        window.location.href = reportURL;
    } else {
        alert("Please select a date range.");
    }
});
