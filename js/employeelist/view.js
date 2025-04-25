// Helper: Format date to "Month Day, Year"
function formatDate(dateStr) {
    if (!dateStr || dateStr === 'N/A' || dateStr === '0000-00-00') return 'N/A';
    const date = new Date(dateStr);
    if (isNaN(date)) return 'N/A';
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

// Helper: Format number of days (e.g., 3.5 -> "3 days and half day")
function formatNumberOfDays(days) {
    var num = parseFloat(days);
    if (isNaN(num)) return days;

    var wholeDays = Math.floor(num);
    var hasHalf = num % 1 !== 0;

    if (wholeDays === 0 && hasHalf) {
        return 'Half day';
    } else if (hasHalf) {
        return `${wholeDays} days and half day`;
    } else {
        return `${wholeDays} ${wholeDays === 1 ? 'day' : 'days'}`;
    }
}

$(document).on('click', '.viewEmployeeBtn', function () {
    console.log("View button clicked!");

    // Get employee details
    var employee_id = $(this).data('employee_id');
    var indexno = $(this).data('indexno');
    var lname = $(this).data('lname');
    var fname = $(this).data('fname');
    var midname = $(this).data('midname');
    var extname = $(this).data('extname');
    var position = $(this).data('position');
    var office = $(this).data('office');
    var gender = $(this).data('gender');
    var status = $(this).data('status');
    

    console.log("Data Retrieved:", { employee_id, indexno, lname, fname, office, gender, status });

    var fullName = lname + ", " + fname + " " + (extname ? extname + " " : "") + (midname ? midname : "");

    // Update Profile Section
    $('#profileIdNumber').text(employee_id);
    $('#fullName').text(fullName);

    // Change Profile Picture Based on Gender
    var profilePic = $("#profilePic");
    if (gender.toLowerCase() === "male") {
        profilePic.attr("src", "../img/male_profile.png");
    } else if (gender.toLowerCase() === "female") {
        profilePic.attr("src", "../img/female_profile.png");
    } else {
        profilePic.attr("src", "../img/profile_app.jpg");
    }

    // Set values for the view modal
    $('#view_employee_id').val(employee_id);
    $('#view_lname').val(lname);
    $('#view_fname').val(fname);
    $('#view_midname').val(midname);
    $('#view_extname').val(extname);
    $('#view_position').val(position);
    $('#view_office').val(office);
    $('#view_gender').val(gender);
    $('#view_status').val(status);
    $('#employeeIdHidden').val(employee_id);
    $('#indexNoHidden').val(indexno);


    // Fetch Leave & Travel History
    $.ajax({
        url: '../function/employeefunction/fetch_history.php',
        type: 'POST',
        data: { employee_id: employee_id, indexno: indexno },
        dataType: 'json',
        success: function (response) {
            console.log("History Fetched:", response);

            // Leave History
            var leaveHtml = "";
            if (response.leave.length > 0) {
                response.leave.forEach(function (leave) {
                    const isSpecific = leave.date_type === 'specific';

                    const startDate = isSpecific ? 'N/A' : formatDate(leave.startdate);
                    const endDate = isSpecific ? 'N/A' : formatDate(leave.enddate);
                    const specificDates = isSpecific && leave.specific_dates
                        ? leave.specific_dates
                            .split(/[\n,;]+/)
                            .map(date => new Date(date.trim()))
                            .filter(dateObj => !isNaN(dateObj))
                            .sort((a, b) => a - b)
                            .map(dateObj => dateObj.toLocaleDateString("en-US", {
                                year: "numeric",
                                month: "long",
                                day: "numeric"
                            }))
                            .join('<br>')
                        : 'N/A';
                

                    leaveHtml += `<tr>
                        <td>${leave.leavetype}</td>
                        <td>${startDate}</td>
                        <td>${endDate}</td>
                        <td>${specificDates}</td>
                        <td>${formatNumberOfDays(leave.numofdays)}</td>
                    </tr>`;
                });
            } else {
                leaveHtml = `<tr><td colspan="5" class="text-center">No leave history available</td></tr>`;
            }
            $("#leaveHistory").html(leaveHtml);

            // Travel History
            var travelHtml = "";
            if (response.travel.length > 0) {
                response.travel.forEach(function (travel) {
                    const specificDates = travel.specific_dates
                        ? travel.specific_dates
                            .split(/[\n,;]+/)
                            .map(date => new Date(date.trim()))
                            .filter(dateObj => !isNaN(dateObj))
                            .sort((a, b) => a - b)
                            .map(dateObj => dateObj.toLocaleDateString("en-US", {
                                year: "numeric",
                                month: "long",
                                day: "numeric"
                            }))
                            .join('<br>')
                        : 'N/A';
                

                    const numOfDays = travel.numofdays ? formatNumberOfDays(travel.numofdays) : 'N/A';

                    travelHtml += `<tr>
                        <td style="white-space: normal; word-wrap: break-word; max-width: 250px;">${travel.purpose}</td>
                        <td style="white-space: normal; word-wrap: break-word; max-width: 250px;">${travel.destination}</td>
                        <td>${formatDate(travel.startdate)}</td>
                        <td>${formatDate(travel.enddate)}</td>
                        <td>${specificDates}</td>
                        <td>${numOfDays}</td>
                    </tr>`;
                
                });
            } else {
                travelHtml = `<tr><td colspan="6" class="text-center">No travel history available</td></tr>`;
            }
            $("#travelHistory").html(travelHtml);
        },
        error: function (xhr, status, error) {
            console.error("Failed to fetch history", xhr.responseText);
        }
    });

    console.log("Sending to fetch_history.php:", { employee_id, indexno });

    // Reset history visibility
    $('#leaveHistoryWrapper').hide();
    $('#travelHistoryWrapper').hide();
    $('#toggleLeaveBtn').text('Show Leave History');
    $('#toggleTravelBtn').text('Show Travel History');

    // Show the modal
    $('#viewEmployeeModal').modal('show');
});

$(document).ready(function () {
    // Initialize end date as disabled on page load
    $('#empReportEnd').prop('disabled', true);
    
    // Toggle report options section
    $('#toggleReportOptions').on('click', function() {
        const wrapper = $('#reportOptionsWrapper');
        wrapper.toggle();

        const isVisible = wrapper.is(':visible');

        $(this).html(isVisible
            ? '<i class="fas fa-times me-1"></i> Hide Report Section'
            : '<i class="fas fa-file-alt me-1"></i> Generate Report Section'
        );

        // Reset fields if hidden
        if (!isVisible) {
            $('#empReportStart').val('');
            $('#empReportEnd').val('').prop('disabled', true);
            $('#reportType').val('leave');
        }
    });
    
    // Reset Generate Report Section when modal is closed
    $('#viewEmployeeModal').on('hidden.bs.modal', function() {
        // Hide the report section
        $('#reportOptionsWrapper').hide();

        // Reset the toggle button text
        $('#toggleReportOptions').html('<i class="fas fa-file-alt me-1"></i> Generate Report Section');

        // Clear the inputs
        $('#empReportStart').val('');
        $('#empReportEnd').val('').prop('disabled', true);
        $('#reportType').val('leave');
    });
    
    // Toggle buttons - IMPORTANT: This is the consolidated event handler section
    $('#toggleLeaveBtn').on('click', function() {
        $('#leaveHistoryWrapper').toggle();
        let text = $('#leaveHistoryWrapper').is(':visible') ? 'Hide Leave History' : 'Show Leave History';
        $(this).text(text);
    });

    $('#toggleTravelBtn').on('click', function() {
        $('#travelHistoryWrapper').toggle();
        let text = $('#travelHistoryWrapper').is(':visible') ? 'Hide Travel History' : 'Show Travel History';
        $(this).text(text);
    });
});

// Handle start date selection
document.getElementById("empReportStart").addEventListener("change", function() {
    const startDate = this.value;
    const endInput = document.getElementById("empReportEnd");
    
    if (startDate) {
        // Enable the end date input when start date is selected
        endInput.disabled = false;
        
        // Set the minimum end date to selected start date
        endInput.min = startDate;
        
        // If current end date is less than start, clear it
        if (endInput.value && endInput.value < startDate) {
            endInput.value = "";
        }
    } else {
        // If start date is cleared, disable and clear end date
        endInput.disabled = true;
        endInput.value = "";
    }
});

// Generate report by date range
document.getElementById("generateEmpLeaveReportBtn").addEventListener("click", function() {
    const empId = document.getElementById("employeeIdHidden").value;
    const start = document.getElementById("empReportStart").value;
    const end = document.getElementById("empReportEnd").value;
    const reportType = document.getElementById("reportType").value;

    // Improved validation with custom modal
    if (!empId || !start || !end) {
        // Create and show a Bootstrap modal for the error
        $('#missingFieldsModal').modal('show');
        return;
    }

    let url = "";

    if (reportType === "leave") {
        url = `../function/employeefunction/generateEmpReport.php?employee_id=${empId}&start=${start}&end=${end}`;
    } else if (reportType === "travel") {
        url = `../function/employeefunction/generateEmpReportTravel.php?employee_id=${empId}&start=${start}&end=${end}`;
    }
    
    window.open(url, '_blank');
});

// Generate all records report
document.getElementById("generateAllReportsBtn").addEventListener("click", function() {
    const empId = document.getElementById("employeeIdHidden").value;
    const reportType = document.getElementById("reportType").value;
    
    if (!empId) {
        alert("Employee ID not found.");
        return;
    }
    
    // Display confirmation modal instead of immediately generating report
    $('#confirmAllReportsModal').modal('show');
    
    // Store the parameters to be used when the user confirms
    $('#confirmAllReportsBtn').data('empId', empId);
    $('#confirmAllReportsBtn').data('reportType', reportType);
});

// Add a new handler for the confirm button in the modal
$(document).on('click', '#confirmAllReportsBtn', function() {
    const empId = $(this).data('empId');
    const reportType = $(this).data('reportType');
    
    let url = "";
    
    if (reportType === "leave") {
        url = `../function/employeefunction/generateEmpReport.php?employee_id=${empId}&all=true`;
    } else if (reportType === "travel") {
        url = `../function/employeefunction/generateEmpReportTravel.php?employee_id=${empId}&all=true`;
    }
    
    // Hide modal and generate report
    $('#confirmAllReportsModal').modal('hide');
    window.open(url, '_blank');
});

// Function to toggle office input field
function toggleOfficeInput() {
    var officeDropdown = document.getElementById("typeOfOffice");
    var customOfficeInput = document.getElementById("customOffice");

    if (officeDropdown.value === "optional") {
        customOfficeInput.style.display = "block";
        customOfficeInput.setAttribute("name", "office"); // Change the name so it's submitted
        customOfficeInput.setAttribute("required", "required");
        officeDropdown.removeAttribute("name"); // Prevents submitting the select field
    } else {
        customOfficeInput.style.display = "none";
        customOfficeInput.removeAttribute("required");
        customOfficeInput.removeAttribute("name");
        officeDropdown.setAttribute("name", "office");
    }
}