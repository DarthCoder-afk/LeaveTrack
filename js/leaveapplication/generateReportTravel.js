document.addEventListener("DOMContentLoaded", function () {
    let startDatePicker = document.getElementById("reportStartDate");
    let endDatePicker = document.getElementById("reportEndDate");
    let generateBtn = document.getElementById("generateReportBtn");
    let generateAllReportsCheckbox = document.getElementById("generateAllReports");

    // Initially disable End Date picker
    endDatePicker.disabled = true;

    // Handle "Generate All Reports" checkbox toggle
    generateAllReportsCheckbox.addEventListener("change", function() {
        // If checkbox is checked, disable date fields
        if (this.checked) {
            startDatePicker.disabled = true;
            endDatePicker.disabled = true;
        } else {
            // If unchecked, only enable start date (end date requires start date selection)
            startDatePicker.disabled = false;
            endDatePicker.disabled = !startDatePicker.value;
        }
    });

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
        // Check if "Generate All Reports" is selected
        const generateAll = generateAllReportsCheckbox.checked;
        
        // Validate date inputs if not generating all reports
        if (!generateAll) {
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
        }

        // Update municipality name/logo first
        const formData = new FormData();
        
        // Add municipality, province and logo file if they exist
        const municipalityInput = document.getElementById("municipalityName");
        const provinceInput = document.getElementById("provinceName");
        const logoFileInput = document.getElementById("logoFile");
        
        if (municipalityInput && municipalityInput.value) {
            formData.append("municipality_name", municipalityInput.value);
        }
        
        if (provinceInput && provinceInput.value) {
            formData.append("province_name", provinceInput.value);
        }
        
        if (logoFileInput && logoFileInput.files[0]) {
            formData.append("logo_file", logoFileInput.files[0]);
        }

        fetch('../function/reportSettings/updateSettings.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(response => {
            // Define the report URL based on checkbox state
            let reportURL;
            
            if (generateAll) {
                reportURL = `../function/leavefunctions/generateReportTravel.php?all=1`;
            } else {
                let startDate = startDatePicker.value;
                let endDate = endDatePicker.value;
                reportURL = `../function/leavefunctions/generateReportTravel.php?start=${startDate}&end=${endDate}`;
            }
            
            if (response.trim() === 'success' || response.includes('success')) {
                // Redirect to the report URL
                window.location.href = reportURL;
                
                // Reset form
                resetForm();
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
    
    // Helper function to reset the form
    function resetForm() {
        // Reset date pickers
        startDatePicker.value = "";
        endDatePicker.value = "";
        endDatePicker.min = "";
        
        // Reset checkbox
        generateAllReportsCheckbox.checked = false;
        
        // Reset field states
        startDatePicker.disabled = false;
        endDatePicker.disabled = true;
    }
});