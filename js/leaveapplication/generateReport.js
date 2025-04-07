    document.addEventListener("DOMContentLoaded", function () {
        let startDatePicker = document.getElementById("reportStartDate");
        let endDatePicker = document.getElementById("reportEndDate");
        let generateBtn = document.getElementById("generateReportBtn");

        endDatePicker.disabled = true;

        startDatePicker.addEventListener("change", function () {
            if (this.value) {
                endDatePicker.disabled = false;
                endDatePicker.min = this.value;
            } else {
                endDatePicker.disabled = true;
                endDatePicker.value = "";
            }
        });

        generateBtn.addEventListener("click", function () {
            const startDate = startDatePicker.value;
            const endDate = endDatePicker.value;

            if (!startDate || !endDate) {
                alert("Please select both Start Date and End Date.");
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
                    const reportURL = `../function/leavefunctions/generateReport.php?start=${startDate}&end=${endDate}`;
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
        });
    });
