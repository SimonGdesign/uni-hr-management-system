<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$payroll_id = $_GET['id'] ?? '';

if (!empty($payroll_id)) {
    $query = "DELETE FROM payslip WHERE payslip_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $payroll_id);
    if ($stmt->execute()) {
        header("Location: dashboard.php?section=payroll&success=Payroll record deleted successfully");
        exit;
    } else {
        header("Location: dashboard.php?section=payroll&error=Error deleting payroll record");
        exit;
    }
    $stmt->close();
} else {
    header("Location: dashboard.php?section=payroll&error=Invalid payroll record ID");
    exit;
}

$conn->close();
?>