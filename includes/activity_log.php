<?php 
include '../database/db_connect.php';

date_default_timezone_set('Asia/Manila');

$result = $conn->query("SELECT * FROM activity_log WHERE activity_date = CURDATE()");

$count = $conn->query("SELECT COUNT(*) AS total FROM activity_log WHERE activity_date = CURDATE()");
$counter = $count->fetch_assoc();


?>

<li class='nav-item dropdown no-arrow mx-1'>
    <a class='nav-link dropdown-toggle' href='#' id='alertsDropdown' role='button' data-toggle='dropdown'
        aria-haspopup='true' aria-expanded='false'>
        <i class='fas fa-bell fa-fw'></i>
        <?php
            if ($counter['total']==0){
                echo "<span class='badge'></span>";
            } else {
                echo "<span class='badge badge-danger badge-counter'>{$counter['total']}</span>";
            }
        ?>
        
    </a>
    <div class='dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in'
        aria-labelledby='alertsDropdown'>
        <h6 class='dropdown-header'>
            Activity Log
        </h6>
        <?php
        if($counter['total'] == 0){
        echo "<a class='dropdown-item d-flex align-items-center' href='#'>
                    <div>
                        No activity today.
                    </div>
                </a>";
        } else {
            while ($row = $result->fetch_assoc()) {
                $activity_type_class = '';
                switch ($row['activity_details']) {
                    case 'added':
                        $activity_type_class = 'bg-success';
                        break;
                    case 'deleted':
                        $activity_type_class = 'bg-danger';
                        break;
                    case 'updated':
                        $activity_type_class = 'bg-primary';
                        break;
                    default:
                        $activity_type_class = 'bg-secondary';
                        break;
                }

                $activity_type_icon = '';
                $activity_grammar = '';
                switch($row['activity_type']) {
                    case 'Employee':
                        $activity_type_icon = 'fas fa-user';
                        $activity_grammar = 'with';
                        break;
                    case 'Leave Application':
                        $activity_type_icon = 'far fa-sticky-note';
                        $activity_grammar = 'for';
                        break;
                    case 'Travel Order':
                        $activity_type_icon = 'fas fa-plane';
                        $activity_grammar = 'for';
                        break;
                    default:
                        $activity_type_icon = '';
                        break;
                }

                $formatted_time = date("H:i A", strtotime($row['activity_time']));
                echo "<a class='dropdown-item d-flex align-items-center' href='#'>
                        <div class='mr-3'>
                            <div class='icon-circle {$activity_type_class}'>
                                <i class='{$activity_type_icon} text-white'></i>
                            </div>
                        </div>
                        <div>
                            {$row['activity_type']} was {$row['activity_details']} {$activity_grammar} ID 00{$row['emp_id']}.
                            <div class='small text-gray-500'>{$formatted_time}</div>
                        </div>
                    </a>";
            }
        }
    
        ?>
        <a class='dropdown-item text-center small text-gray-500' href='#'>Show All Activities</a>
    </div>
</li>