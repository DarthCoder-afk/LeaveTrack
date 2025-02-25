$(document).on('click', '.deletebtn', function(event) {
    event.preventDefault(); // Prevent immediate redirection
    var index_no = $(this).data('indexno');

    console.log(index_no);
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
        window.location.href = "../function/travelfunctions/deletetravel.php?index_no=" + index_no; // Redirect if confirmed
      }
    });
  });