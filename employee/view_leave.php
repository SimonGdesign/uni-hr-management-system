<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['employee_id']) && !isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$employee_id = $_SESSION['employee_id'] ?? null;
$is_admin = isset($_SESSION['admin']);

$query = "SELECT * FROM leave_requests";
if (!$is_admin) {
    $query .= " WHERE employee_id = ?";
}

$stmt = $conn->prepare($query);

if (!$is_admin) {
    $stmt->bind_param("i", $employee_id);
}

$stmt->execute();
$result = $stmt->get_result();
$leave_requests = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Requests</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Leave Requests</h1>
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <?php if ($is_admin): ?>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leave_requests as $leave): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($leave['leave_type']); ?></td>
                            <td><?php echo htmlspecialchars($leave['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($leave['end_date']); ?></td>
                            <td><?php echo htmlspecialchars($leave['reason']); ?></td>
                            <td><?php echo htmlspecialchars($leave['status']); ?></td>
                            <?php if ($is_admin): ?>
                            <td>
                                <a href="edit_leave.php?id=<?php echo $leave['id']; ?>" class="btn">Edit</a>
                                <a href="delete_leave.php?id=<?php echo $leave['id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this leave request?');">Delete</a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>