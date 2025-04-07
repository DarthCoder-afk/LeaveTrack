<?php
require('../../database/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Fetch existing settings
    $existingQuery = "SELECT municipality_name, logo_path FROM settings WHERE id = 1";
    $existingResult = $conn->query($existingQuery);
    $existing = $existingResult->fetch_assoc();

    $municipalityName = isset($_POST['municipality_name']) && $_POST['municipality_name'] !== ''
        ? $_POST['municipality_name']
        : $existing['municipality_name'];

    // Step 2: Handle logo upload (optional)
    $logoPath = $existing['logo_path']; // default to existing
    if (isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../img/';
        $fileName = basename($_FILES['logo_file']['name']);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $targetFilePath)) {
            $logoPath = $targetFilePath;
        }
    }

    // Step 3: Insert or update settings
    $query = "INSERT INTO settings (id, municipality_name, logo_path)
              VALUES (1, ?, ?)
              ON DUPLICATE KEY UPDATE municipality_name = VALUES(municipality_name), logo_path = VALUES(logo_path)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $municipalityName, $logoPath);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Failed to update.";
    }

    $stmt->close();
    $conn->close();
}
?>
