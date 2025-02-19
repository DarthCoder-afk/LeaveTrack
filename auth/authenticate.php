<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../database/db_connect.php"; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $data = mysqli_query($conn, "SELECT * FROM login WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($data) == 1) {
        $_SESSION['message'] = "success";
        $_SESSION['username'] = $username; // Store username in session
        $_SESSION['auth_key'] = bin2hex(random_bytes(32)); // Generate secure token
    } else {
        $_SESSION['message'] = "error";
    }

    // Redirect back to login.php (SweetAlert will handle the UI feedback)
    header("Location: ../pages/login.php");
    exit();
}
?>
