<?php
session_start();
require '../db_connection.php';

$error = "";
$success = "";

// Fetch employees and their current attendance status
$attendance = [];
$query = "SELECT employee_id, employee_name, status FROM attendance";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
} else {
    $attendance = null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updates = $_POST['attendance'] ?? [];

    if (!empty($updates)) {
        $stmt = $conn->prepare("UPDATE attendance SET status = ? WHERE employee_id = ?");

        foreach ($updates as $employee_id => $status) {
            $stmt->bind_param("si", $status, $employee_id);
            if (!$stmt->execute()) {
                $error = "Error updating attendance: " . $stmt->error;
                break;
            }
        }

        if (empty($error)) {
            $success = "Attendance updated successfully.";
        }

        $stmt->close();
    } else {
        $error = "No attendance records to update.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendance</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Manage Attendance</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if (!empty($success)) { echo "<p style='color: green;'>$success</p>"; } ?>
            <form method="POST" action="manage_attendance.php">
                <table class="employee-table">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($attendance)): ?>
                            <?php foreach ($attendance as $record): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($record['employee_name']); ?></td>
                                    <td>
                                        <select name="attendance[<?php echo $record['employee_id']; ?>]" class="glass-input">
                                            <option value="Present" <?php echo $record['status'] == 'Present' ? 'selected' : ''; ?>>Present</option>
                                            <option value="Absent" <?php echo $record['status'] == 'Absent' ? 'selected' : ''; ?>>Absent</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No attendance records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn">Update Attendance</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>