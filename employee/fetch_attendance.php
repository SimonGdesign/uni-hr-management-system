<?php
require '../db_connection.php';

$attendance = [];
$query = "SELECT employee_id, status FROM attendance";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
} else {
    $attendance = null;
}
?>