<?php
require '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_id = $_POST['application_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $query = "UPDATE applications SET status = 'approved' WHERE application_id = ?";
    } elseif ($action === 'reject') {
        $query = "UPDATE applications SET status = 'rejected' WHERE application_id = ?";
    }

    if (isset($query)) {
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param('i', $application_id);
            if ($stmt->execute()) {
                echo "Application has been " . htmlspecialchars($action) . "d.";
            } else {
                echo "Execute Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Prepare Error: " . $conn->error;
        }
    } else {
        echo "Query Error: No valid query found.";
    }
} else {
    echo "Invalid Request Method.";
}
$conn->close();

// Redirect back to the dashboard
header("Location: dashboard.php");
exit();