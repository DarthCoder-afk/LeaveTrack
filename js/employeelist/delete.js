$(document).on('click', '.deletebtn', async function(event) {
    event.preventDefault(); // Prevent immediate redirection
    var employee_id = $(this).data('employee_id');

    const { value: password } = await Swal.fire({
      title: "Enter your password",
      input: "password",
      inputLabel: "Password",
      inputPlaceholder: "Enter your password",
      inputAttributes: {
        maxlength: "30",
        autocapitalize: "off",
        autocorrect: "off"
      },
      showCancelButton: true,
      confirmButtonText: "Delete",
      cancelButtonText: "Cancel"
    });
    if (password) {
      $.ajax({
        url: "../auth/verify.php",
        type: "POST",
        data: { password: password , employee_id: employee_id},
        
        success: function(response) {
          console.log("response:", response);
          console.log("password:", password);
          if (response === 'success') {
            window.location.href = "../function/employeefunction/delete.php?employee_id=" + employee_id;
          } else {
            Swal.fire({
              icon: "error",
              title: "Incorrect Password",
              text: "The password you entered is incorrect. Please try again."
            });
          }
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error:", status, error);
          console.error("Response Text:", xhr.responseText);
          Swal.fire({
              icon: "error",
              title: "Request Failed",
              text: "Something went wrong. Please try again later."
          });
      },
      complete: function(xhr) {
          console.log("Complete Response:", xhr.responseText);
      }
        
      });
    }

  });