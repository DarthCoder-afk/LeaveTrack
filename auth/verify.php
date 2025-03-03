<?php 
session_start();
include '../database/db_connect.php';

if(isset($_POST['password'])) {
    $password = $_POST['password'];
   

    $stored_password = $conn->query("SELECT password FROM login")->fetch_assoc()['password'];

    if($password === $stored_password) {
        echo 'success' ;
    } else {
        echo 'error' ;
    }
}

?>