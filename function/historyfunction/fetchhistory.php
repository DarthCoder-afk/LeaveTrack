<?php
    include '../database/db_connect.php';
    date_default_timezone_set('Asia/Manila');
    $result = $conn->query("SELECT * FROM activity_log ORDER BY CONCAT(activity_date, ' ', activity_time) DESC");
    $counter = 1; // Initialize the counter for the "No." column
   
    while ($row = $result->fetch_assoc()) {
        $date =  htmlspecialchars(date("F d, Y", strtotime($row['activity_date'])), ENT_QUOTES) ;
        $time = htmlspecialchars(date("g:i A", strtotime($row['activity_time'])), ENT_QUOTES);
        $datetime = "{$date} {$time}";
        $formatted_emp_id = str_pad($row['emp_id'], 3, "0", STR_PAD_LEFT);

        $activity_grammar = '';
                switch($row['activity_type']) {
                    case 'Employee':
                        $activity_grammar = 'with';
                        break;
                    case 'Leave Application':
                        $activity_grammar = 'for';
                        break;
                    case 'Travel Order':
                        $activity_grammar = 'for';
                        break;
                    default:
                        break;
                }
        $activity = '';
        switch ($row['activity_details']) {
            case 'added':
                $activity = '<span class="badge badge-success">added</span>';
                break;
            case 'deleted':
                $activity = '<span class="badge badge-danger">deleted</span>';
                break;
            case 'updated':
                $activity = '<span class="badge badge-info">updated</span>';
                break;
            default:
                break;
        }
        echo "<tr class='text-center'>";
        echo "<td>{$counter}</td>";
        echo "<td>{$row['activity_type']} was {$activity} {$activity_grammar} ID {$formatted_emp_id}.</td>";
        echo "<td>{$datetime}</td>";

        $counter++;
    } 

?>

