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
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Account Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="img/Talisay.png" class="rounded-circle" alt="User Profile">
                        </div>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Username</label>
                                <input type="text" class="form-control" id="name" placeholder="LGU Talisay Admin" disabled>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-warning">Change Password</button>
                                <button type="button" class="btn btn-secondary">Update Username</button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
