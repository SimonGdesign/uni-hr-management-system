<?php
require '../db_connection.php';

$awards_data = [];
$query = "SELECT employee_id, award_name, date, description FROM awards";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $awards_data[] = $row;
    }
} else {
    $awards_data = null;
}
?>