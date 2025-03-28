<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$attendance_id = $_GET['id'] ?? '';
$attendance = null;

if (!empty($attendance_id)) {
    $query = "SELECT * FROM attendance WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $attendance_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $attendance = $result->fetch_assoc();
    }
    $stmt->close();
}

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'] ?? '';
    $status = $_POST['status'] ?? '';

    // Validate form data
    if (!empty($date) && !empty($status)) {
        // Update attendance
        $query = "UPDATE attendance SET date = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $date, $status, $attendance_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=attendance&success=Attendance updated successfully");
            exit;
        } else {
            $error = "Error updating attendance: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "All fields are required.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attendance</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Edit Attendance</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if ($attendance): ?>
                <form method="POST" action="edit_attendance.php?id=<?php echo htmlspecialchars($attendance_id); ?>">
                    <input type="date" name="date" class="glass-input" value="<?php echo htmlspecialchars($attendance['date']); ?>" required>
                    <select name="status" class="glass-input" required>
                        <option value="Present" <?php echo $attendance['status'] == 'Present' ? 'selected' : ''; ?>>Present</option>
                        <option value="Absent" <?php echo $attendance['status'] == 'Absent' ? 'selected' : ''; ?>>Absent</option>
                    </select>
                    <button class="btn" type="submit">Update Attendance</button>
                </form>
            <?php else: ?>
                <p>Attendance record not found.</p>
            <?php endif; ?>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>