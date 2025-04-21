<?php
include '../database/db_connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    die("Error: User not logged in.");
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
    $current_username = $_SESSION['username'];

    $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'login'");
    if (mysqli_num_rows($table_check) == 0) {
        die("Error: 'login' table does not exist.");
    }

    $check_query = "SELECT * FROM login WHERE username='$new_username'";
    $check_result = mysqli_query($conn, $check_query);

    if (!$check_result) {
        die("Error in SELECT query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($check_result) > 0) {
        echo "Username already taken!";
        exit;
    }

    $update_query = "UPDATE login SET username='$new_username' WHERE username='$current_username'";
    if (mysqli_query($conn, $update_query)) {
        session_unset();
        session_destroy();
        echo "success: Username successfully updated!";
    } else {
        echo "Error updating username: " . mysqli_error($conn);
    }
}
?>
