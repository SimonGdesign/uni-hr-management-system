<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['employee_id']) && !isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$employee_id = $_SESSION['employee_id'] ?? null;
$is_admin = isset($_SESSION['admin']);

$query = "SELECT * FROM accounts";
if (!$is_admin) {
    $query .= " WHERE employee_id = ?";
}

$stmt = $conn->prepare($query);

if (!$is_admin) {
    $stmt->bind_param("i", $employee_id);
}

$stmt->execute();
$result = $stmt->get_result();
$accounts = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Accounts</h1>
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <?php if ($is_admin): ?>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $account): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($account['username']); ?></td>
                            <td><?php echo htmlspecialchars($account['email']); ?></td>
                            <td><?php echo htmlspecialchars($account['role']); ?></td>
                            <?php if ($is_admin): ?>
                            <td>
                                <a href="edit_account.php?id=<?php echo $account['account_id']; ?>" class="btn">Edit</a>
                                <a href="delete_account.php?id=<?php echo $account['account_id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this account?');">Delete</a>
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