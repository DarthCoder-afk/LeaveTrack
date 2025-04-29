$(document).ready(function() {
    // Function to load inactive employees
    function loadInactiveEmployees() {
        $.ajax({
            url: '../function/employeefunction/fetch_inactive.php',
            type: 'GET',
            success: function(data) {
                $('#inactiveEmployeesList').html(data);
                
                // Initialize DataTable for inactive employees table
                if ($.fn.DataTable.isDataTable('#inactiveEmployeesTable')) {
                    $('#inactiveEmployeesTable').DataTable().destroy();
                }
                
                $('#inactiveEmployeesTable').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "pageLength": 10
                });
            },
            error: function() {
                $('#inactiveEmployeesList').html('<tr><td colspan="5" class="text-center">Error loading inactive employees</td></tr>');
            }
        });
    }

    // Load inactive employees when the modal is opened
    $('#inactiveEmployeesModal').on('show.bs.modal', function() {
        loadInactiveEmployees();
    });
    
    // Function to format date from YYYY-MM-DD to Month DD, YYYY
    function formatDate(dateString) {
        if (!dateString || dateString === '0000-00-00' || dateString === 'null' || dateString === '') {
            return 'N/A';
        }
        
        const date = new Date(dateString);
        if (isNaN(date.getTime())) {
            return 'N/A';
        }
        
        return date.toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
    }
    
    // Function to format number of days
    function formatDays(numDays) {
        if (numDays === null || numDays === undefined || numDays === '') {
            return 'N/A';
        }
        
        // Convert to number if it's a string
        numDays = parseFloat(numDays);
        
        if (isNaN(numDays)) {
            return 'N/A';
        }
        
        // Check if it's .5 (half day)
        if (numDays === 0.5) {
            return 'Half day';
        }
        
        // Return as integer if it's a whole number
        if (Number.isInteger(numDays)) {
            return numDays.toString();
        }
        
        // Handle other decimal values
        if (numDays % 0.5 === 0) {
            const wholeDay = Math.floor(numDays);
            return wholeDay + (wholeDay === 1 ? ' day' : ' days') + ' and Half day';
        }
        
        return numDays.toString();
    }
    
    // Function to handle viewing employee details from inactive list
    window.viewEmployee = function(element) {
        const button = $(element);
        const employee_id = button.data('employee_id');
        const fname = button.data('fname');
        const lname = button.data('lname');
        const midname = button.data('midname');
        const extname = button.data('extname');
        const position = button.data('position');
        const office = button.data('office');
        const gender = button.data('gender');
        const status = button.data('status');
        const index_no = button.data('index_no');
        
        // Close the inactive employees modal first
        $('#inactiveEmployeesModal').modal('hide');
        
        // Wait for the modal to close before opening the view modal
        setTimeout(function() {
            // Reset history displays
            $('#leaveHistory').html('<tr><td colspan="5" class="text-center">Loading leave history...</td></tr>');
            $('#travelHistory').html('<tr><td colspan="6" class="text-center">Loading travel history...</td></tr>');
            
            // Reset history visibility
            $('#leaveHistoryWrapper').hide();
            $('#travelHistoryWrapper').hide();
            $('#toggleLeaveBtn').text('Show Leave History');
            $('#toggleTravelBtn').text('Show Travel History');
            
            // Set profile information
            $('#fullName').text(lname + ', ' + fname + (midname ? ' ' + midname[0] + '.' : '') + (extname ? ' ' + extname : ''));
            $('#profileIdNumber').text(employee_id);
            
            // Set input fields
            $('#view_employee_id').val(employee_id);
            $('#view_lname').val(lname);
            $('#view_fname').val(fname);
            $('#view_midname').val(midname);
            $('#view_extname').val(extname);
            $('#view_position').val(position);
            $('#view_office').val(office);
            $('#view_gender').val(gender);
            $('#view_status').val(status);
            
            // Store for report generation
            $('#employeeIdHidden').val(employee_id);
            $('#indexNoHidden').val(index_no);
            
            // Change Profile Picture Based on Gender
            var profilePic = $("#profilePic");
            if (gender.toLowerCase() === "male") {
                profilePic.attr("src", "../img/male_profile.png");
            } else if (gender.toLowerCase() === "female") {
                profilePic.attr("src", "../img/female_profile.png");
            } else {
                profilePic.attr("src", "../img/default_profile.png");
            }
            
            // Fetch leave and travel history
            $.ajax({
                url: '../function/employeefunction/fetch_history.php',
                type: 'POST',
                data: {
                    employee_id: employee_id,
                    indexno: index_no
                },
                dataType: 'json',
                success: function(data) {
                    // Process leave history
                    if (data.leave && data.leave.length > 0) {
                        let leaveHtml = '';
                        $.each(data.leave, function(index, item) {
                            // Format specific dates if they exist
                            let specificDates = 'N/A';
                            if (item.specific_dates && item.specific_dates !== 'N/A') {
                                // Split by commas and format each date
                                const dates = item.specific_dates.split(/[\n,;]+/).map(date => date.trim());
                                const formattedDates = dates.map(date => formatDate(date));
                                specificDates = formattedDates.join('<br>');
                            }
                            
                            leaveHtml += `<tr>
                                <td>${item.leavetype}</td>
                                <td>${formatDate(item.startdate)}</td>
                                <td>${formatDate(item.enddate)}</td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">${specificDates}</td>
                                <td>${formatDays(item.numofdays)}</td>
                            </tr>`;
                        });
                        $('#leaveHistory').html(leaveHtml);
                    } else {
                        $('#leaveHistory').html('<tr><td colspan="5" class="text-center">No leave history available</td></tr>');
                    }
                    
                    // Process travel history
                    if (data.travel && data.travel.length > 0) {
                        let travelHtml = '';
                        $.each(data.travel, function(index, item) {
                            // Format specific dates if they exist
                            let specificDates = 'N/A';
                            if (item.specific_dates && item.specific_dates !== 'N/A') {
                                // Split by commas and format each date
                                const dates = item.specific_dates.split(/[\n,;]+/).map(date => date.trim());
                                const formattedDates = dates.map(date => formatDate(date));
                                specificDates = formattedDates.join('<br>');
                            }
                            
                            travelHtml += `<tr>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">${item.purpose}</td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">${item.destination}</td>
                                <td>${formatDate(item.startdate)}</td>
                                <td>${formatDate(item.enddate)}</td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">${specificDates}</td>
                                <td>${formatDays(item.numofdays)}</td>
                            </tr>`;
                        });
                        $('#travelHistory').html(travelHtml);
                    } else {
                        $('#travelHistory').html('<tr><td colspan="6" class="text-center">No travel history available</td></tr>');
                    }
                },
                error: function() {
                    $('#leaveHistory').html('<tr><td colspan="5" class="text-center">Error loading leave history</td></tr>');
                    $('#travelHistory').html('<tr><td colspan="6" class="text-center">Error loading travel history</td></tr>');
                }
            });
            
            // Open the view modal
            $('#viewEmployeeModal').modal('show');
        }, 500);
    };

    // Reset history visibility when view modal is closed
    $('#viewEmployeeModal').on('hidden.bs.modal', function() {
        // Reset history visibility
        $('#leaveHistoryWrapper').hide();
        $('#travelHistoryWrapper').hide();
        $('#toggleLeaveBtn').text('Show Leave History');
        $('#toggleTravelBtn').text('Show Travel History');
        
        // Also reset report options if they were visible
        $('#reportOptionsWrapper').hide();
        $('#toggleReportOptions').html('<i class="fas fa-file-alt me-1"></i> Generate Report Section');
        $('#empReportStart').val('');
        $('#empReportEnd').val('').prop('disabled', true);
        $('#reportType').val('leave');
        $('#generateAllReports').prop('checked', false);
    });
});