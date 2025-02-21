$(document).on('click', '.deletebtn', function(event) {
    event.preventDefault(); // Prevent immediate redirection
    var employee_id = $(this).data('employee_id');

    Swal.fire({
      title: "Are you sure?",
      text: "You will be deleting this data",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete!"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "../function/leavefunctions/deleteleave.php?employee_id=" + employee_id; // Redirect if confirmed
      }
    });
  });