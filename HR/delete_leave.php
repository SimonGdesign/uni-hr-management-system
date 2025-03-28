<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$leave_id = $_GET['id'] ?? '';

if (!empty($leave_id)) {
    $query = "DELETE FROM leave_requests WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $leave_id);
    if ($stmt->execute()) {
        header("Location: dashboard.php?section=leave&success=Leave request deleted successfully");
        exit;
    } else {
        header("Location: dashboard.php?section=leave&error=Error deleting leave request");
        exit;
    }
    $stmt->close();
} else {
    header("Location: dashboard.php?section=leave&error=Invalid leave request ID");
    exit;
}

$conn->close();
?>