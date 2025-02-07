<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['auth_key'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}
?>
