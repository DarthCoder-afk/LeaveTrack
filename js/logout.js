document.getElementById("logout-link").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent immediate redirection

    Swal.fire({
      title: "Are you sure?",
      text: "You will be logged out!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, logout!"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "../auth/logout.php"; // Redirect if confirmed
      }
    });
  });