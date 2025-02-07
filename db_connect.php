<?php
session_start(); // Start session globally

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrmoleave";

// Establish database connection
$check = mysqli_connect($servername, $username, $password, $dbname);

if (!$check) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>
