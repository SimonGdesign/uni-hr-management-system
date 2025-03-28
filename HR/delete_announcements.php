<?php
session_start();
require '../db_connection.php';

// Validate and sanitize input
$department_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($department_id) {
    // Corrected column name from "id" to "department_id"
    $query = "DELETE FROM departments WHERE department_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $department_id);
        
        if ($stmt->execute()) {
            header("Location: dashboard.php?section=departments&success=Department deleted successfully");
            exit;
        } else {
            header("Location: dashboard.php?section=departments&error=Error deleting department");
            exit;
        }

        $stmt->close();
    } else {
        header("Location: dashboard.php?section=departments&error=Error preparing statement");
        exit;
    }
} else {
    header("Location: dashboard.php?section=departments&error=Invalid department ID");
    exit;
}

$conn->close();
?>
