<?php
include '../database/db_connect.php';

// Helper to convert a date into readable text or show "N/A"
function toTextDate($date) {
    if (
        empty($date) || 
        $date === '0000-00-00' || 
        $date === '-0001-11-30' ||
        $date === '1970-01-01'
    ) {
        return 'N/A';
    }
    $ts = strtotime($date);
    return $ts ? date("F j, Y", $ts) : htmlspecialchars($date);
}

// Format number of days to text (e.g., "1.5" becomes "1 day and half day")
function formatDaysToText($numDays) {
    if (empty($numDays)) return 'N/A';
    
    // Convert to float to handle decimal values properly
    $numDays = (float)$numDays;
    
    // Get whole days and check if there's a fraction
    $wholeDays = floor($numDays);
    $hasFraction = $numDays - $wholeDays > 0;
    
    // Format whole days part with proper pluralization
    $result = '';
    if ($wholeDays > 0) {
        $result = $wholeDays . ' ' . ($wholeDays == 1 ? 'day' : 'days');
        
        // Add "and" if we also have a fraction
        if ($hasFraction) {
            $result .= ' and ';
        }
    }
    
    // Add half day if there's a fraction
    // Currently only handles .5 as "half day"
    if ($hasFraction) {
        $result .= 'half day';
    }
    
    return $result ? $result : 'N/A';
}

// Updated query: LEFT JOIN and fallback to 'Deleted Employee'
$query = "
    SELECT 
        l.employee_id, 
        CONCAT(l.emp_lname, ', ', l.emp_fname, ' ', COALESCE(l.emp_extname, ''), ' ', COALESCE(l.emp_midname, '')) AS full_name, 
        l.dateapplied, 
        l.startdate, 
        l.enddate, 
        l.specific_dates, 
        l.numofdays
    FROM leaveapplication l 
    WHERE l.leavetype = 'Monetization'
    ORDER BY l.dateapplied ASC
";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<tr data-employee-id='" . htmlspecialchars($row['employee_id']) . "'>";

    echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";

    echo "<td>" . toTextDate($row['dateapplied']) . "</td>";
    echo "<td>" . toTextDate($row['startdate']) . "</td>";
    echo "<td>" . toTextDate($row['enddate']) . "</td>";

    // Format specific_dates
    if (!empty($row['specific_dates'])) {
        $rawDates = preg_split('/[\n,]+/', $row['specific_dates']);
        $dateObjects = [];

        foreach ($rawDates as $dateStr) {
            $dateStr = trim($dateStr);
            $timestamp = strtotime($dateStr);
            if ($timestamp) {
                $dateObjects[] = $timestamp;
            }
        }

        sort($dateObjects);

        echo "<td>";
        foreach ($dateObjects as $ts) {
            echo date("F j, Y", $ts) . "<br>";
        }
        echo "</td>";
    } else {
        echo "<td>N/A</td>";
    }
    
    // Use the new formatting function for numofdays
    echo "<td>" . formatDaysToText($row['numofdays']) . "</td>";

    echo "</tr>";
}
?>