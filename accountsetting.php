<?php
include 'auth.php'; // Ensure authentication

//echo "Welcome, " . $_SESSION['username'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/admin.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/admin.min.css" rel="stylesheet">
</head>
<body id="page-top">
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php" style="background-color: #2e8517;">
        <div class="sidebar-brand-icon">
          <img src="img/HR.png" style="border-radius: 50%;">
        </div>
        <div class="sidebar-brand-text mx-3">HR Admin</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
          aria-expanded="true" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Leave Applications</span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">View</h6>
            <a class="collapse-item" href="applications.php">Applications</a>
            <a class="collapse-item" href="view_calendar.php">Calendar</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
          aria-controls="collapseForm">
          <i class="fab fa-fw fa-wpforms"></i>
          <span>Forms</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Forms</h6>
            <a class="collapse-item" href="leave_form.php">Leave Form</a>
            <a class="collapse-item" href="#">Travel Form</a>
          </div>
        </div>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="accountsetting.php">
          <i class="fas fa-cog"></i>
          <span>Account Settings</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="logout-link" href="#">
          <i class="fas fa-sign-out-alt"></i>
          <span>Log-out</span>
        </a>
      </li>
      <hr class="sidebar-divider">
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top" style="background-color: #2e8517;">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                      aria-label="Search" aria-describedby="basic-addon2" style="border-color: #2e8517;">

                  </div>
                </form>
              </div>
            </li>
            

            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="#" role="#" data-toggle="#"
                aria-haspopup="false" aria-expanded="false">
                <img class="img-profile rounded-circle" src="img/profile.jpg" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">Administrator</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Account Setting</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Account Setting</li>
            </ol>
          </div>


    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white text-center">
                        <h4>Account Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                        <img src="img/HR.png" class="rounded-circle" alt="User Profile" style="width: 300px; height: 300px;">
                        </div>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Username</label>
                                <input type="text" class="form-control" id="name" value="<?php echo $_SESSION['username']; ?>" disabled>
                            </div>
                            <div class="d-flex justify-content-center gap-5">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateUsernameModal">Update Username</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" style="margin-top: 200px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Username Modal -->
    <div class="modal fade" id="updateUsernameModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" style="margin-top: 250px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Username</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateUsernameForm">
                        <div class="mb-3">
                            <label class="form-label">New Username</label>
                            <input type="text" class="form-control" id="new_username" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Update Username</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal (Pop-up) -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="errorText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for Form Validation -->
    <script>
    document.getElementById("changePasswordForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form submission

        let newPassword = document.getElementById("new_password").value;
        let confirmPassword = document.getElementById("confirm_password").value;
        let errorText = document.getElementById("errorText");
        let errorModal = new bootstrap.Modal(document.getElementById("errorModal"));

        // Check if passwords match
        if (newPassword !== confirmPassword) {
            errorText.innerText = "Passwords do not match!"; // Set error message
            errorModal.show(); // Show error pop-up
            return;
        }

        alert("Password change request submitted!");
    });

    document.getElementById("updateUsernameForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form submission

        let newUsername = document.getElementById("new_username").value;
        if (newUsername.trim() === "") {
            let errorText = document.getElementById("errorText");
            let errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
            errorText.innerText = "Username cannot be empty!";
            errorModal.show();
            return;
        }

        alert("Username update request submitted!");
    });
    </script>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
     <!-- Clickable Date JS -->
    <script src="calendar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>


    <script>
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
            window.location.href = "logout.php"; // Redirect if confirmed
          }
        });
      });
    </script>

</body>
</html>
