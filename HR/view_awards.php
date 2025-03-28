```php name=view_awards.php
<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['employee_id']) && !isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$employee_id = $_SESSION['employee_id'] ?? null;
$is_admin = isset($_SESSION['admin']);

$query = "SELECT * FROM awards";
if (!$is_admin) {
    $query .= " WHERE employee_id = ?";
}

$stmt = $conn->prepare($query);

if (!$is_admin) {
    $stmt->bind_param("i", $employee_id);
}

$stmt->execute();
$result = $stmt->get_result();
$awards = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awards</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Awards</h1>
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>Award Name</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Description</th>
                        <?php if ($is_admin): ?>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($awards as $award): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($award['award_name']); ?></td>
                            <td><?php echo htmlspecialchars($award['employee_id']); ?></td>
                            <td><?php echo htmlspecialchars($award['date']); ?></td>
                            <td><?php echo htmlspecialchars($award['description']); ?></td>
                            <?php if ($is_admin): ?>
                            <td>
                                <a href="edit_award.php?id=<?php echo $award['award_id']; ?>" class="btn">Edit</a>
                                <a href="delete_award.php?id=<?php echo $award['award_id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this award?');">Delete</a>
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