<?php
//session_start(); // Start session globally

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrmoleave";

// Establish database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>
