<?php
// Show errors for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../database/db_connect.php'; // Include database connection

// Function to safely format dates or return 'N/A'
function formatDateSafe($date) {
    if (
        empty($date) || 
        $date === '0000-00-00' || 
        $date === '-0001-11-30' || 
        $date === 'November 30, -0001'
    ) {
        return 'N/A';
    }
    return date("F j, Y", strtotime($date));
}

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Use LEFT JOIN and fallback for deleted employees
$query = "
    SELECT 
        l.employee_id, 
        COALESCE(CONCAT(e.lname, ', ', e.fname, ' ', COALESCE(e.extname, ''), ' ', COALESCE(e.midname, '')), 'Deleted Employee') AS full_name, 
        l.purpose, 
        l.destination, 
        l.dateapplied,
        l.startdate, 
        l.enddate, 
        l.specific_dates
    FROM travelorder l 
    LEFT JOIN employee e ON e.indexno = l.emp_index
    WHERE MONTH(l.dateapplied) = ? AND YEAR(l.dateapplied) = ?
    ORDER BY l.dateapplied ASC
";

$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ii", $currentMonth, $currentYear);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();

if (!$result) {
    die("Result fetch failed: " . $stmt->error);
}

while ($row = $result->fetch_assoc()) {
    echo "<tr data-employee-id='" . htmlspecialchars($row['employee_id']) . "'>";
    echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
    echo "<td style='white-space: normal; word-wrap: break-word; word-break: break-word;'>" . htmlspecialchars($row['purpose']) . "</td>";
    echo "<td style='white-space: normal; word-wrap: break-word; word-break: break-word;'>" . htmlspecialchars($row['destination']) . "</td>";

    // Format and display dates nicely
    echo "<td>" . formatDateSafe($row['dateapplied']) . "</td>";
    echo "<td>" . formatDateSafe($row['startdate']) . "</td>";
    echo "<td>" . formatDateSafe($row['enddate']) . "</td>";

    // Handle specific dates
    if (!empty($row['specific_dates'])) {
        $rawDates = preg_split('/[\n,]+/', $row['specific_dates']);
        $dateObjects = [];

        foreach ($rawDates as $dateStr) {
            $dateStr = trim($dateStr);
            if (!empty($dateStr)) {
                $timestamp = strtotime($dateStr);
                if ($timestamp) {
                    $dateObjects[] = new DateTime($dateStr);
                }
            }
        }

        usort($dateObjects, function ($a, $b) {
            return $a <=> $b;
        });

        echo "<td>";
        foreach ($dateObjects as $dateObj) {
            echo $dateObj->format("F j, Y") . "<br>";
        }
        echo "</td>";
    } else {
        echo "<td>N/A</td>";
    }

    echo "</tr>";
}

$stmt->close();
$conn->close();
?>
