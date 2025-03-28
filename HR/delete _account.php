<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$account_id = $_GET['id'] ?? '';

if (!empty($account_id)) {
    $query = "DELETE FROM accounts WHERE account_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $account_id);
    if ($stmt->execute()) {
        header("Location: dashboard.php?section=accounts&success=Account deleted successfully");
        exit;
    } else {
        header("Location: dashboard.php?section=accounts&error=Error deleting account");
        exit;
    }
    $stmt->close();
} else {
    header("Location: dashboard.php?section=accounts&error=Invalid account ID");
    exit;
}

$conn->close();
?>