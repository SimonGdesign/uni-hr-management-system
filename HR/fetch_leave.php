<?php
require '../db_connection.php';

$leave_data = [];
$query = "SELECT employee_id, leave_type, start_date, end_date, status FROM leaverequests";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leave_data[] = $row;
    }
} else {
    $leave_data = null;
}
?>