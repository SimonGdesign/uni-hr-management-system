```php name=delete_department.php
<?php
session_start();
require '../db_connection.php';

$department_id = $_GET['id'] ?? '';

if (!empty($department_id)) {
    $query = "DELETE FROM departments WHERE id = ?";
    $stmt = $conn->prepare($query);
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
    header("Location: dashboard.php?section=departments&error=Invalid department ID");
    exit;
}

$conn->close();
?>