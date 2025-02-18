<?php 
include "../database/db_connect.php"; // Include database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="icon" type="image/png" href="../img/favicon.ico">
    <title>Login | HRMO</title>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
       <div class="row border rounded-5 p-3 bg-white shadow box-area">
       
           <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #2e8517;">
               <div class="featured-image mb-3">
                <img src="../img/logo.png" class="img-fluid" style="width: 250px;">
               </div>
               <p class="text-white fs-2">Track Leaves</p>
               <small class="text-white text-center">Monitor leave requests effortlessly in one place.</small>
           </div> 
        
           <div class="col-md-6 right-box">
              <div class="row align-items-center">
                    <div class="header-text mb-4">
                         <h2>Hello!</h2>
                         <p>Welcome to the Leave Tracking System.</p>
                    </div>
                    <form action="../auth/authenticate.php" method="POST">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Username" name="username" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" name="password" required>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                        </div>
                    </form>
              </div>
           </div> 

      </div>
    </div>

    <!-- SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert Logic -->
    <?php if (isset($_SESSION['message'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                <?php if ($_SESSION['message'] == "success"): ?>
                    Swal.fire({
                        title: 'Login Successful!',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '../pages/index.php'; // Redirect to dashboard
                    });
                <?php elseif ($_SESSION['message'] == "error"): ?>
                    Swal.fire({
                        title: 'Wrong Credentials',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                <?php endif; ?>
            });
        </script>
    <?php 
        unset($_SESSION['message']); // Clear session message after showing alert
    endif; ?>



</body>
</html>
