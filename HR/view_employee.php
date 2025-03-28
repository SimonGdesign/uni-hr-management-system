<?php
require '../db_connection.php';

if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];
    
    $query = "SELECT e.employee_id, e.full_name, e.role, d.name AS department, e.email, e.phone 
              FROM employees e
              JOIN departments d ON e.department_id = d.department_id
              WHERE e.employee_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    $stmt->close();
} else {
    header("Location: dashboard.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="employee-container">
        <h1>Employee Details</h1>
        <?php if ($employee): ?>
            <p><strong>Employee ID:</strong> <?php echo htmlspecialchars($employee['employee_id']); ?></p>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($employee['full_name']); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($employee['role']); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($employee['department']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($employee['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($employee['phone']); ?></p>
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        <?php else: ?>
            <p>Employee not found.</p>
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        <?php endif; ?>
    </div>
</body>
</html>