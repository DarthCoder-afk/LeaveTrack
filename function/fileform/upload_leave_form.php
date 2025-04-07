<?php
session_start();
include '../../database/db_connect.php'; // Ensure this path is correct

$uploadDir = '../../uploads/';
$uploadFile = $uploadDir . basename($_FILES['leaveFile']['name']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['leaveFile']) && $_FILES['leaveFile']['error'] === UPLOAD_ERR_OK) {
        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        if ($fileType === 'pdf') {
            // Rename file to avoid duplicates
            $newFileName = 'leave_form_' . time() . '.pdf';
            $newFilePath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['leaveFile']['tmp_name'], $newFilePath)) {
                // Prepare values
                $fileName = $newFileName;
                $fileSize = $_FILES['leaveFile']['size'];
                $fileData = ''; // Optional (can be used to store binary if needed)
                $uploadTime = date("Y-m-d H:i:s");

                // Insert into database using correct column names
                $stmt = $conn->prepare("INSERT INTO leave_files (file_name, file_type, file_size, file_data, upload_time) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssiss", $fileName, $fileType, $fileSize, $fileData, $uploadTime);
                $stmt->execute();
                $stmt->close();

                // ✅ Redirect to the correct page after successful upload
                header('Location: http://localhost/LeaveTrack/pages/leave_form.php?upload=success');
                exit();
            } else {
                echo "❌ Error: Unable to move the uploaded file. Please check if the 'uploads' folder exists and is writable.";
            }
        } else {
            echo "❌ Only PDF files are allowed.";
        }
    } else {
        echo "❌ File upload failed or no file was selected.";
    }
}
?>
