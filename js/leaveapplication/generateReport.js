document.addEventListener("DOMContentLoaded", function () {
    let startDatePicker = document.getElementById("reportStartDate");
    let endDatePicker = document.getElementById("reportEndDate");
    let generateBtn = document.getElementById("generateReportBtn");
    let allReportsCheckbox = document.getElementById("generateAllReports");
    let reportModal = document.getElementById("reportModal");
    let closeButtons = document.querySelectorAll('[data-dismiss="modal"]');

    endDatePicker.disabled = true;

    // Function to reset all form fields
    function resetReportForm() {
        startDatePicker.value = "";
        endDatePicker.value = "";
        endDatePicker.min = "";
        endDatePicker.disabled = true;
        allReportsCheckbox.checked = false;
        startDatePicker.disabled = false;
        
        // Reset any other form fields if needed
        if (document.getElementById("municipalityName")) {
            document.getElementById("municipalityName").value = "";
        }
        if (document.getElementById("provinceName")) {
            document.getElementById("provinceName").value = "";
        }
        if (document.getElementById("logoFile")) {
            document.getElementById("logoFile").value = "";
        }
    }

    // Add event listeners for all close buttons (X and "Close" button)
    closeButtons.forEach(button => {
        button.addEventListener("click", resetReportForm);
    });

    // Also listen for Bootstrap's hidden.bs.modal event which fires when modal is fully closed
    $(reportModal).on('hidden.bs.modal', resetReportForm);

    // Toggle date pickers based on "All Reports" checkbox
    allReportsCheckbox.addEventListener("change", function() {
        if (this.checked) {
            // Clear and disable the date pickers immediately
            startDatePicker.value = "";
            endDatePicker.value = "";
            startDatePicker.disabled = true;
            endDatePicker.disabled = true;
        } else {
            // Enable the start date picker when unchecked
            startDatePicker.disabled = false;
            // End date stays disabled until start date is selected
        }
    });

    startDatePicker.addEventListener("change", function () {
        if (this.value && !allReportsCheckbox.checked) {
            endDatePicker.disabled = false;
            endDatePicker.min = this.value;
        } else {
            endDatePicker.disabled = true;
            endDatePicker.value = "";
        }
    });

    generateBtn.addEventListener("click", function () {
        const generateAll = allReportsCheckbox.checked;
        let startDate = startDatePicker.value;
        let endDate = endDatePicker.value;

        // Validate inputs if not generating all reports
        if (!generateAll && (!startDate || !endDate)) {
            alert("Please select both Start Date and End Date, or check 'Generate All Reports'.");
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
                // Create URL based on selection
                let reportURL;
                if (generateAll) {
                    reportURL = `../function/leavefunctions/generateReport.php?all=true`;
                } else {
                    reportURL = `../function/leavefunctions/generateReport.php?start=${startDate}&end=${endDate}`;
                }
                
                window.location.href = reportURL;
                
                // Reset form after successful generation
                resetReportForm();
            } else {
                alert("Failed to update settings before generating the report.");
                console.error("Settings update failed:", response);
            }
        })
        .catch(err => {
            alert("Something went wrong. Try again.");
            console.error(err);
        });
    });
});