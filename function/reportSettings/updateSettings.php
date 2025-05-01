<?php
require('../../database/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Fetch existing or fallback values
    $existingQuery = "SELECT municipality_name, province_name, logo_path FROM settings WHERE id = 1";
    $existingResult = $conn->query($existingQuery);
    $existing = $existingResult->fetch_assoc() ?? [
        'municipality_name' => '',
        'province_name' => '',
        'logo_path' => ''
    ];

    $municipalityName = isset($_POST['municipality_name']) && $_POST['municipality_name'] !== ''
        ? $_POST['municipality_name']
        : $existing['municipality_name'];

    $provinceName = isset($_POST['province_name']) && $_POST['province_name'] !== ''
        ? $_POST['province_name']
        : $existing['province_name'];

    $logoPath = $existing['logo_path'];
    if (isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] === UPLOAD_ERR_OK) {
        // Use a simpler relative path structure
        $uploadDir = '../img/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileName = basename($_FILES['logo_file']['name']);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $targetFilePath)) {
            // Store the simpler relative path in database
            $logoPath = '../img/' . $fileName;
        }
    }

    $query = "INSERT INTO settings (id, municipality_name, province_name, logo_path)
              VALUES (1, ?, ?, ?)
              ON DUPLICATE KEY UPDATE 
                municipality_name = VALUES(municipality_name), 
                province_name = VALUES(province_name),
                logo_path = VALUES(logo_path)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $municipalityName, $provinceName, $logoPath);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Failed to update. Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>