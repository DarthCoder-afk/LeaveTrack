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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white text-center">
                        <h4>Account Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="img/Talisay.png" class="rounded-circle" alt="User Profile">
                        </div>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Username</label>
                                <input type="text" class="form-control" id="name" value="<?php echo $_SESSION['username']; ?>" disabled>
                            </div>
                            <div class="d-grid gap-2">
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
        <div class="modal-dialog">
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
        <div class="modal-dialog">
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

</body>
</html>
