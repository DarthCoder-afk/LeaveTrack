<?php
include '../config/db_connect.php'; // Adjust the path based on your setup

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    // Fetch Leave History
    $leave_query = "SELECT * FROM leave_applications WHERE employee_id = '$employee_id' ORDER BY date_applied DESC";
    $leave_result = mysqli_query($conn, $leave_query);

    // Fetch Travel History
    $travel_query = "SELECT * FROM travel_records WHERE employee_id = '$employee_id' ORDER BY travel_date DESC";
    $travel_result = mysqli_query($conn, $travel_query);
} else {
    echo "No employee ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee History</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Leave & Travel History</h2>
        
        <!-- Leave History -->
        <h4 class="mt-4">Leave History</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($leave_result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['leave_type']) ?></td>
                        <td><?= htmlspecialchars($row['start_date']) ?></td>
                        <td><?= htmlspecialchars($row['end_date']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Travel History -->
        <h4 class="mt-4">Travel History</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Destination</th>
                    <th>Travel Date</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($travel_result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['destination']) ?></td>
                        <td><?= htmlspecialchars($row['travel_date']) ?></td>
                        <td><?= htmlspecialchars($row['purpose']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
