<?php
session_start();
require '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_id = $_POST['leave_id'] ?? '';
    $status = $_POST['status'] ?? '';

    if (!empty($leave_id) && !empty($status)) {
        $query = "UPDATE leaverequests SET status = ? WHERE leave_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $leave_id);
        if ($stmt->execute()) {
            header("Location: dashboard.php?section=leave&success=Leave status updated successfully");
            exit;
        } else {
            header("Location: dashboard.php?section=leave&error=Error updating leave status");
            exit;
        }
        $stmt->close();
    } else {
        header("Location: dashboard.php?section=leave&error=All fields are required");
        exit;
    }
}

$conn->close();
?>