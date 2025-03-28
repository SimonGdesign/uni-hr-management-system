<?php
session_start();
require '../db_connection.php';

$error = "";
$success = "";

// Fetch leave requests
$leave_data = [];
$query = "SELECT leave_id, employee_id, leave_type, start_date, end_date, status FROM leaverequests";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leave_data[] = $row;
    }
} else {
    $leave_data = null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updates = $_POST['leave'] ?? [];

    if (!empty($updates)) {
        $stmt = $conn->prepare("UPDATE leaverequests SET status = ? WHERE leave_id = ?");

        foreach ($updates as $leave_id => $status) {
            $stmt->bind_param("si", $status, $leave_id);
            if (!$stmt->execute()) {
                $error = "Error updating leave status: " . $stmt->error;
                break;
            }
        }

        if (empty($error)) {
            $success = "Leave status updated successfully.";
        }

        $stmt->close();
    } else {
        $error = "No leave records to update.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leave</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Manage Leave</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if (!empty($success)) { echo "<p style='color: green;'>$success</p>"; } ?>
            <form method="POST" action="manage_leave.php">
                <table class="employee-table">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Leave Type</th>
                            <th>Dates</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($leave_data)): ?>
                            <?php foreach ($leave_data as $leave): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($leave['employee_id']); ?></td>
                                    <td><?php echo htmlspecialchars($leave['leave_type']); ?></td>
                                    <td><?php echo htmlspecialchars($leave['start_date']); ?> to <?php echo htmlspecialchars($leave['end_date']); ?></td>
                                    <td>
                                        <select name="leave[<?php echo $leave['leave_id']; ?>]" class="glass-input">
                                            <option value="Pending" <?php echo $leave['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Approved" <?php echo $leave['status'] == 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                            <option value="Rejected" <?php echo $leave['status'] == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No leave records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn">Update Leave</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>