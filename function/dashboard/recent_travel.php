<?php
include '../database/db_connect.php';

// Updated query to join using indexno instead of employee_id
$result = $conn->query("
    SELECT employee.indexno, employee.lname, employee.fname, 
           travelorder.purpose, travelorder.dateapplied 
    FROM employee 
    INNER JOIN travelorder ON employee.indexno = travelorder.emp_index 
    ORDER BY travelorder.dateapplied DESC 
    LIMIT 2
");

while ($row = $result->fetch_assoc()) {
    $full_name = "{$row['lname']}, {$row['fname']}";
?>
    <div class="customer-message align-items-center">
        <a class="font-weight-bold" href="#">
            <div class="text-truncate message-title text-dark">
                <?php echo $row['purpose']; ?> 
            </div>
            <div class="small text-gray-500 message-time font-weight-bold">
                <?php echo $full_name; ?> · <?php echo $row['dateapplied']; ?>
            </div>
        </a>
    </div>
<?php
}
?>
