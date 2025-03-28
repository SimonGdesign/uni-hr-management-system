<?php
// Establish a database connection
require '../db_connection.php';

$awards_data = [];

// Fetch awards from the database
$query = "SELECT * FROM awards";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $awards_data[] = $row;
    }
}

$conn->close();