<?php
require '../db_connection.php';

if (isset($_GET['id'])) {
    $listing_id = $_GET['id'];

    // Prepare SQL statement
    $stmt = $conn->prepare("DELETE FROM joblistings WHERE listing_id = ?");
    $stmt->bind_param("i", $listing_id);

    if ($stmt->execute()) {
        $success = "Job listing deleted successfully.";
    } else {
        $error = "Error deleting job listing: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    $error = "Invalid request.";
}

// Close the connection
$conn->close();

// Redirect back to dashboard with success or error message
header("Location: dashboard.php?message=" . urlencode($success ?? $error));
exit();
?>