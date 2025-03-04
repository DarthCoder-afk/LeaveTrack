<?php 
session_start();
include '../database/db_connect.php';

$response = array('success' => false);

if(isset($_POST['password'])) {
    $password = $_POST['password'];
    $stored_password = $_SESSION['password'];

    if($password === $stored_password) {
        $response['success'] = true;
    } 
}

echo json_encode($response);
?>