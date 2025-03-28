<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['employee_id']) && !isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$employee_id = $_SESSION['employee_id'] ?? null;
$is_admin = isset($_SESSION['admin']);

$query = "SELECT * FROM payslip";
if (!$is_admin) {
    $query .= " WHERE employee_id = ?";
}

$stmt = $conn->prepare($query);

if (!$is_admin) {
    $stmt->bind_param("i", $employee_id);
}

$stmt->execute();
$result = $stmt->get_result();
$payroll_records = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Records</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Payroll Records</h1>
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Employee</th>
                        <th>Basic Salary</th>
                        <th>Allowances</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <?php if ($is_admin): ?>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payroll_records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['month']); ?></td>
                            <td><?php echo htmlspecialchars($record['employee_id']); ?></td>
                            <td><?php echo htmlspecialchars($record['basic_salary']); ?></td>
                            <td><?php echo htmlspecialchars($record['allowances']); ?></td>
                            <td><?php echo htmlspecialchars($record['deductions']); ?></td>
                            <td><?php echo htmlspecialchars($record['net_salary']); ?></td>
                            <?php if ($is_admin): ?>
                            <td>
                                <a href="edit_payroll.php?id=<?php echo $record['payslip_id']; ?>" class="btn">Edit</a>
                                <a href="delete_payroll.php?id=<?php echo $record['payslip_id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this payroll record?');">Delete</a>
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