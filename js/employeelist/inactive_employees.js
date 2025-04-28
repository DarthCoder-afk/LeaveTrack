$(document).ready(function() {
    // Function to load inactive employees
    function loadInactiveEmployees() {
        $.ajax({
            url: '.../function/employeefunction/fetch_inactive.php',
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
    
    // Additional function to handle viewing employee details from inactive list
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
            
            // Open the view modal
            $('#viewEmployeeModal').modal('show');
        }, 500);
    };
});