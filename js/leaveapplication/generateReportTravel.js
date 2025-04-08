document.addEventListener("DOMContentLoaded", function () {
    let startDatePicker = document.getElementById("reportStartDate");
    let endDatePicker = document.getElementById("reportEndDate");
    let generateBtn = document.getElementById("generateReportBtn");

    // Initially disable End Date picker
    endDatePicker.disabled = true;

    startDatePicker.addEventListener("change", function () {
        let startDate = this.value;

        // Enable End Date picker only when Start Date is selected
        if (startDate) {
            endDatePicker.disabled = false;
            endDatePicker.min = startDate; // Set minimum selectable date
        } else {
            endDatePicker.disabled = true;
            endDatePicker.value = ""; // Reset End Date if Start Date is cleared
        }
    });

    generateBtn.addEventListener("click", function () {
        let startDate = startDatePicker.value;
        let endDate = endDatePicker.value;

        if (!startDate.trim()) {
            alert("⚠ Please select a Start Date first.");
            return;
        }

        if (!endDate.trim()) {
            alert("⚠ Please select an End Date.");
            return;
        }

        // Update municipality name/logo first
        const formData = new FormData(document.getElementById("reportForm"));

        fetch('../function/reportSettings/updateSettings.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(response => {
            if (response.trim() === 'success') {
                const reportURL = `../function/leavefunctions/generateReportTravel.php?start=${startDate}&end=${endDate}`;
                window.location.href = reportURL;
                startDatePicker.value = "";
                endDatePicker.value = "";
                endDatePicker.min = "";
                endDatePicker.disabled = true;
            } else {
                alert("Failed to update settings before generating the report.");
                console.error("Settings update failed:", response);
            }
        })
        .catch(err => {
            alert("Something went wrong. Try again.");
            console.error(err);
        });

        // Reset date pickers after clicking "Generate"
        setTimeout(() => {
            startDatePicker.value = "";
            endDatePicker.value = "";
            endDatePicker.min = "";
            endDatePicker.disabled = true; // Disable End Date again after generating report
        }, 1000);

        // Open report
        window.location.href = reportURL;
    });
});
