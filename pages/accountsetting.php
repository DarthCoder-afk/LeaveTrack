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

    <!-- Custom styles for this page -->
    <style>
        .card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .card:hover {
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
            border-color: #28a745;
        }
        
        .btn {
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .btn-outline-secondary {
            border-width: 2px;
        }
        
        .btn-outline-secondary:hover {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-2px);
        }
        
        .settings-toggle-btn {
            background-color: #f8f9fa;
            color: #495057;
            border: 2px solid #28a745;
            padding: 10px 20px;
            font-weight: 600;
        }
        
        .settings-toggle-btn:hover {
            background-color: #28a745;
            color: white;
        }
        
        .settings-card {
            border: 2px solid #28a745;
        }
        
        .settings-header {
            background-color: #28a745;
            color: white;
            font-weight: 600;
            padding: 12px 20px;
        }
        
        .selected-file {
            margin-top: 5px;
            font-size: 12px;
            color: #28a745;
            font-weight: 500;
            display: none;
        }
        
        .input-group-text {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }
        

        
        .modal-content {
            border-radius: 12px;
            border: none;
            overflow: hidden;
        }
        
        .modal-header {
            border-bottom: none;
            padding: 1.5rem 1.5rem 0.75rem;
        }
        
        .modal-footer {
            border-top: none;
            padding: 0.75rem 1.5rem 1.5rem;
        }
        
        .btn-close-custom {
            background: none;
            border: none;
            color: white;
            font-size: 1.25rem;
            opacity: 0.8;
            transition: opacity 0.3s ease;
            padding: 0;
            margin: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .btn-close-custom:hover {
            opacity: 1;
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>
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
                        <button type="button" class="btn-close-custom text-dark" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                        </button>
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
                        <button type="button" class="btn-close-custom text-dark" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                        </button>
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
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Error</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3 text-center">
                        <i class="fas fa-exclamation-circle text-danger fa-3x mb-2"></i>
                        <p id="errorText" class="mb-0"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closeErrorModal()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toggle Button -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Toggle Button -->
                    <div class="text-center mb-3">
                        <button class="btn btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#updateForm">
                            <i class="fas fa-cog me-1"></i> Update Municipality, Province or Logo
                        </button>
                    </div>

                    <!-- Collapsible Card -->
                    <div class="collapse" id="updateForm">
                        <div class="card settings-card shadow-lg border-0 rounded-lg mb-4">
                            <div class="card-header bg-success text-white text-center py-3">
                                <h4 class="mb-0"><i class="fas fa-building me-2"></i> Update Municipality / Province / Logo</h4>
                            </div>
                            <div class="card-body p-4">
                                <form id="settingsForm" action="../function/reportSettings/updateSettings.php" method="POST" enctype="multipart/form-data">
                                    <div class="row g-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold"><i class="fas fa-map-marker-alt me-1"></i>Municipality Name</label>
                                            <input type="text" name="municipality_name" class="form-control" placeholder="Enter Municipality">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold"><i class="fas fa-globe-asia me-1"></i>Province Name</label>
                                            <input type="text" name="province_name" class="form-control" placeholder="Enter Province">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold"><i class="fas fa-image me-1"></i>Change Logo</label>
                                        <div class="input-group">
                                            <input type="file" id="logo_file" name="logo_file" accept="image/*" class="form-control" aria-describedby="inputGroupFileAddon">
                                            <span class="input-group-text" id="inputGroupFileAddon"><i class="fas fa-upload"></i></span>
                                        </div>
                                        <div id="selected-file" class="selected-file mt-1"><i class="fas fa-check-circle me-1"></i><span id="file-name" class="small"></span></div>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100 mt-3">
                                        <i class="fas fa-save me-1"></i> Update Settings
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel"><i class="fas fa-check-circle me-2"></i>Update Successful</h5>
            </div>
            <div class="modal-body p-3 text-center">
                <i class="fas fa-check-circle text-success fa-3x mb-2"></i>
                <p class="mb-0">The settings have been updated successfully.</p>
                <div class="mt-3">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Refreshing page...</p>
                </div>
            </div>
            </div>
        </div>
        </div>


    <script>
    // File upload preview
    document.getElementById('logo_file').addEventListener('change', function() {
        const fileInput = this;
        const fileName = document.getElementById('file-name');
        const selectedFile = document.getElementById('selected-file');
        
        if (fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
            selectedFile.style.display = 'block';
        } else {
            selectedFile.style.display = 'none';
        }
    });
    
    // Function for automatic page refresh (no longer needed to close modal manually)
    function refreshPage() {
        window.location.reload();
    }
    
    // Function to close error modal
    function closeErrorModal() {
        const errorModalElement = document.getElementById('errorModal');
        const errorModal = bootstrap.Modal.getInstance(errorModalElement);
        if (errorModal) {
            errorModal.hide();
        }
    }
    
    // Fix for modal close buttons
    document.addEventListener('DOMContentLoaded', function() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            });
        });
    });
    
    const form = document.getElementById('settingsForm');
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(form.action, {
        method: 'POST',
        body: formData
        })
        .then(res => res.text())
        .then(response => {
        if (response.trim() === 'success') {
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            form.reset();
            document.getElementById('selected-file').style.display = 'none';
            
            // Add automatic page refresh after 2 seconds
            setTimeout(function() {
                refreshPage();
            }, 2000);
        } else {
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            document.getElementById('errorText').textContent = 'Update failed: ' + response;
            errorModal.show();
        }
        })
        .catch(err => {
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            document.getElementById('errorText').textContent = 'Error: ' + err;
            errorModal.show();
        });
    });
    </script>

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