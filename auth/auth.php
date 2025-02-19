<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username']) || !isset($_SESSION['auth_key'])) {
    header("Location: ../pages/login.php"); // Redirect to login if not authenticated
    exit();
}
?>