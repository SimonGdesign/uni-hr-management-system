<?php
require '../db_connection.php';

$sql = "SELECT * FROM departments ORDER BY name ASC";
$result = $conn->query($sql);

$departments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}

$conn->close();
?>