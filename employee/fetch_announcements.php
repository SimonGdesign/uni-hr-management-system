<?php
require '../db_connection.php';

$announcements = [];
$query = "SELECT title, content, created_at FROM announcements";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
} else {
    $announcements = null;
}
?>