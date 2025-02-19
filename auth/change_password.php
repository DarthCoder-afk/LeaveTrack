<?php
include '../database/db_connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['username'])) {
        die("Error: User not logged in.");
    }

    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $username = $_SESSION['username']; // Get current logged-in user

    // Ensure database connection exists
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Validate new password
    if ($new_password !== $confirm_password) {
        die("Error: New passwords do not match!");
    }

    // Get current password from database (without hashing)
    $query = "SELECT password FROM login WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error in SELECT query: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        die("Error: No user found with this username.");
    }

    // Check if entered password matches stored password
    if ($current_password !== $row['password']) {
        die("Error: Current password is incorrect!");
    }

    // Update password in database
    $update_query = "UPDATE login SET password='$new_password' WHERE username='$username'";
    if (mysqli_query($conn, $update_query)) {
        echo "Password successfully updated!";
    } else {
        die("Error updating password: " . mysqli_error($conn));
    }
}
?>
