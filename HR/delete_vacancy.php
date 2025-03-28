<?php
session_start();
require '../db_connection.php';

$listing_id = $_GET['id'] ?? '';

if (!empty($listing_id)) {
    $query = "DELETE FROM job_listings WHERE listing_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $listing_id);
    if ($stmt->execute()) {
        header("Location: dashboard.php?section=job_listings&success=Job listing deleted successfully");
        exit;
    } else {
        header("Location: dashboard.php?section=job_listings&error=Error deleting job listing");
        exit;
    }
    $stmt->close();
} else {
    header("Location: dashboard.php?section=job_listings&error=Invalid job listing ID");
    exit;
}

$conn->close();
?>