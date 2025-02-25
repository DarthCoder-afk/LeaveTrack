<?php
    include '../database/db_connect.php';
    $result = $conn->query("SELECT * FROM employee, travelorder WHERE employee.employee_id = travelorder.employee_id ORDER BY travelorder.dateapplied DESC LIMIT 2");
    while ($row = $result->fetch_assoc()) {

        $full_name = "{$row['lname']}, {$row['fname']}";
?>
    <div class="text-truncate message-title text-dark"><?php echo $row['purpose']; ?> </div>
    <div class="small text-gray-500 message-time font-weight-bold"><?php echo $full_name; ?> · <?php echo $row['dateapplied']; ?></div>
    <hr>

<?php
    }
    ?>