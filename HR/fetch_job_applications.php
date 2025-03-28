<?php
// Establish a database connection
require '../db_connection.php';

$job_applications = [];

// Fetch job applications from the database
$query = "SELECT * FROM applications";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $job_applications[] = $row;
    }
}

$conn->close();