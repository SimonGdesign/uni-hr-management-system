```php name=delete_award.php
<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$award_id = $_GET['id'] ?? '';

if (!empty($award_id)) {
    $query = "DELETE FROM awards WHERE employee_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $award_id);
    if ($stmt->execute()) {
        header("Location: dashboard.php?section=awards&success=Award deleted successfully");
        exit;
    } else {
        header("Location: dashboard.php?section=awards&error=Error deleting award");
        exit;
    }
    $stmt->close();
} else {
    header("Location: dashboard.php?section=awards&error=Invalid award ID");
    exit;
}

$conn->close();
?>