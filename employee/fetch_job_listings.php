<?php
require '../db_connection.php';

$job_listings = [];
$query = "SELECT title, department, description FROM joblistings";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $job_listings[] = $row;
    }
} else {
    $job_listings = null;
}
?>