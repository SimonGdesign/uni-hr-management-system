<?php
require '../db_connection.php';

if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // Prepare SQL statement
    $stmt = $conn->prepare("DELETE FROM employees WHERE employee_id = ?");
    $stmt->bind_param("i", $employee_id);

    if ($stmt->execute()) {
        $success = "Employee deleted successfully.";
    } else {
        $error = "Error deleting employee: " . $stmt->error;
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