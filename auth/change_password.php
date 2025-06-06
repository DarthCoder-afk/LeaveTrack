<?php
include '../database/db_connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['username'])) {
        die("Error: User not logged in.");
    }

    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $username = $_SESSION['username'];

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    if ($new_password !== $confirm_password) {
        die("Error: New passwords do not match!");
    }

    // Get the current password from the database (plain text)
    $query = "SELECT password FROM login WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        die("Error: No user found.");
    }

    $row = $result->fetch_assoc();
    $stored_password = $row['password'];

    // Plain text comparison (not secure, only for testing)
    if ($current_password !== $stored_password) {
        die("Error: Current password is incorrect!");
    }

    // Update with new plain text password (again: not secure)
    $update_query = "UPDATE login SET password = ? WHERE username = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ss", $new_password, $username);

    if ($update_stmt->execute()) {
        session_unset();
        session_destroy();
        echo "success: Password changed. Logging out...";
    } else {
        die("Error updating password: " . $conn->error);
    }
}
?>
