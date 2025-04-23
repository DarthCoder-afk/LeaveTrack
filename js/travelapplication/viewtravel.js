$(document).on('click', '.viewTravelBtn', function () {
    console.log("View button clicked!");

    var employee_id = $(this).data('employee_id');
    var lname = $(this).data('lname');
    var fname = $(this).data('fname');
    var midname = $(this).data('midname');
    var extname = $(this).data('extname');
    var position = $(this).data('position');
    var office = $(this).data('office');
    var purpose = $(this).data('purpose');
    var destination = $(this).data('destination');
    var dateapplied = $(this).data('dateapplied');
    var startdate = $(this).data('startdate');
    var enddate = $(this).data('enddate');
    var numdays = $(this).data('numdays');
    var file = $(this).data('file');
    var datetype = $(this).data('datetype');
    var specificdates = $(this).data('specificdates');
    var gender = $(this).data('gender');

    console.log("Data Retrieved:", {
        employee_id, lname, fname, position, office, purpose, destination,
        dateapplied, startdate, enddate, numdays, datetype, specificdates
    });

    var fullName = lname + ", " + fname + " " + (extname ? extname + " " : "") + (midname ? midname : "");
    $('#profileIdNumber').text(employee_id);
    $('#fullName').text(fullName);

    // Profile Picture by Gender
    var profilePic = $("#profilePic");
    if (gender.toLowerCase() === "male") {
        profilePic.attr("src", "../img/male_profile.png");
    } else if (gender.toLowerCase() === "female") {
        profilePic.attr("src", "../img/female_profile.png");
    } else {
        profilePic.attr("src", "../img/profile_app.jpg");
    }

    // Format Date Helper
    function formatDate(rawDate) {
        if (!rawDate || rawDate === "0000-00-00") return "No Record";
        const dateObj = new Date(rawDate);
        return dateObj.toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric"
        });
    }
    

    function formatNumberOfDays(numdays) {
        const num = parseFloat(numdays);
        const wholeDays = Math.floor(num);
        const hasHalf = (Math.round((num - wholeDays) * 10) / 10) === 0.5;
    
        if (num === 0.5) {
            return 'Half day';
        } else if (hasHalf) {
            return `${wholeDays} days and half day`;
        } else {
            return `${wholeDays} ${wholeDays === 1 ? 'day' : 'days'}`;
        }
    }
    

    // Basic Info
    $('#viewLastName').val(lname);
    $('#viewFirstName').val(fname);
    $('#viewPosition').val(position);
    $('#viewOffice').val(office);
    $('#viewPurpose').val(purpose);
    $('#viewDestination').val(destination);
    $('#viewDateApplied').val(formatDate(dateapplied));
    $('#viewNumberOfDays').val(formatNumberOfDays(numdays));

    // Handle Date View Logic
    if (datetype === 'specific') {
        $('#specificDatesGroup').removeClass('d-none');
        $('#consecutiveDatesGroup').addClass('d-none');
        $('#consecutiveDatesGroupEnd').addClass('d-none');

        if (specificdates) {
            let formattedDates = specificdates
                .split(/[\n,;]+/)  // Split on newlines, commas, or semicolons
                .map(dateStr => dateStr.trim())
                .filter(dateStr => dateStr.length > 0)
                .map(dateStr => new Date(dateStr))
                .filter(dateObj => !isNaN(dateObj)) // Valid dates only
                .sort((a, b) => a - b)
                .map(dateObj => dateObj.toLocaleDateString("en-US", {
                    year: "numeric",
                    month: "long",
                    day: "numeric"
                }))
                .join('\n');

            $('#viewSpecificDates').val(formattedDates);
        } else {
            $('#viewSpecificDates').val('');
        }

    } else {
        $('#specificDatesGroup').addClass('d-none');
        $('#consecutiveDatesGroup').removeClass('d-none');
        $('#consecutiveDatesGroupEnd').removeClass('d-none');

        $('#viewStartDate').val(formatDate(startdate));
        $('#viewEndDate').val(formatDate(enddate));
    }


    // Handle Attached File
    if (file && file !== "null") {
        $('#view_file_btn').attr('href', '../uploads/' + file).removeClass('d-none');
    } else {
        $('#view_file_btn').addClass('d-none');
    }

    $('#ViewTravelModal').modal('show');
});
