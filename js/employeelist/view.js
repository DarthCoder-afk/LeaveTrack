$(document).ready(function() {
    $(".viewbtn").on("click", function() {
        var employee_id = $(this).data("employee_id");
        var lname = $(this).data("lname");
        var fname = $(this).data("fname");
        var midname = $(this).data("midname") || "N/A";
        var extname = $(this).data("extname") || "N/A";
        var position = $(this).data("position");
        var office = $(this).data("office");
        var gender = $(this).data("gender");

        $("#view_employee_id").text(employee_id);
        $("#view_lname").text(lname);
        $("#view_fname").text(fname);
        $("#view_midname").text(midname);
        $("#view_extname").text(extname);
        $("#view_position").text(position);
        $("#view_office").text(office);
        $("#view_gender").text(gender);
    });
});
