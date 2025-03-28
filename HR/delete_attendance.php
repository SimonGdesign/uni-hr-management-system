<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$attendance_id = $_GET['id'] ?? '';

if (!empty($attendance_id)) {
    $query = "DELETE FROM attendance WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $attendance_id);
    if ($stmt->execute()) {
        header("Location: dashboard.php?section=attendance&success=Attendance record deleted successfully");
        exit;
    } else {
        header("Location: dashboard.php?section=attendance&error=Error deleting attendance record");
        exit;
    }
    $stmt->close();
} else {
    header("Location: dashboard.php?section=attendance&error=Invalid attendance record ID");
    exit;
}

$conn->close();
?>