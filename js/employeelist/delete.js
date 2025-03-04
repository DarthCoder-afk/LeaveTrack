$(document).ready(function () {
  
  $('#verifyModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var employee_id = button.data('employee_id');
    
      $('#verifyPassword').val('');
      $('#verifyForm').off('submit').on('submit', function (e) {
          e.preventDefault();
          var password = $('#verifyPassword').val();

          $.ajax({
              url: '../auth/verify.php',
              type: 'POST',
              data: {
                  employee_id: employee_id,
                  password: password
              },
              success: function (response) {
                  console.log("Server Response:", response);
                  
                  // Parse the JSON response
                  var jsonResponse = JSON.parse(response);

                  if (jsonResponse.success) {
                      $('#verifyModal').modal('hide');
                      window.location.href = "../function/employeefunction/delete.php?employee_id=" + employee_id; // Redirect
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Incorrect Password!',
                          text: 'The password you entered is incorrect. Please try again.',
                      });
                  }
              },
              error: function () {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: 'An error occurred. Please try again later.'
                  });
              }
          });
      });
  });
});