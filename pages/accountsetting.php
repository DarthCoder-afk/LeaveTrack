<?php
include '../auth/auth.php'; // Ensure authentication
//echo "Welcome, " . $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../img/favicon.ico" rel="icon">
    <title>HR Admin - Account Settings</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../css/admin.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/admin.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body id="page-top">
<div id="wrapper">
     <!-- Sidebar&Topbar -->
     <?php include '../includes/sidebar.php'; ?>
     <!-- Sidebar&Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Account Setting</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Account Setting</li>
            </ol>
          </div>


          <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header bg-success text-white text-center py-3">
                            <h4 class="mb-0">Account</h4>
                        </div>
                        <div class="card-body text-center">
                            <img src="../img/HR.png" class="rounded-circle mb-3 border border-3" alt="User Profile" style="width: 150px; height: 150px;">
                            <div class="mb-4">
                                <label class="form-label text-success fw-bold">Username</label>
                                <input type="text" class="form-control w-50 mx-auto text-center" value="<?php echo $_SESSION['username']; ?>" disabled>
                            </div>
                            <div class="d-flex justify-content-center" style="gap: 10px;">
                                <button class="btn btn-outline-primary px-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    Change Password
                                </button>
                                <button class="btn btn-outline-warning px-2" data-bs-toggle="modal" data-bs-target="#updateUsernameModal">
                                    Update Username
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: red; font-size: 20px; font-weight: bold; background: none; border: none;">X</button>

                    </div>
                    <div class="modal-body">
                    <form id="changePasswordForm" action="../auth/change_password.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Password</button>
                    </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateUsernameModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">Update Username</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: red; font-size: 20px; font-weight: bold; background: none; border: none;">X</button>

                    </div>
                    <div class="modal-body">
                        <form id="updateUsernameForm" action="../auth/change_username.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">New Username</label>
                                <input type="text" id="new_username" name="new_username" class="form-control" required>
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
    <script src="../js/accountsetting/change.js"></script>
    <script src="../js/accountsetting/updatealert.js"></script>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
     <!-- Clickable Date JS -->
    <script src="calendar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/ruang-admin.min.js"></script>
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/logout.js"></script>

</body>
</html>
