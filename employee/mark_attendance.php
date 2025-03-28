<?php

$error = "";
$success = "";
$email= $_SESSION['email'];
$today = date('Y-m-d');
$sql = "SELECT employee_id FROM employees WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($employee_id);
$stmt->fetch();
$stmt->close();




// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'] ?? '';

    // Validate form data
    if (!empty($employee_id) && !empty($today) && !empty($status)) {
        // Check if the attendance record already exists for the given date
        $query = "SELECT * FROM attendance WHERE employee_id = ? AND date = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $employee_id, $today);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "You have already marked your attendance for today.";
        } else {
            // Insert new attendance record
            $query = "INSERT INTO attendance (employee_id, date, status) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iss", $employee_id, $today, $status);

            if ($stmt->execute()) {
                $success = "Attendance marked successfully.";
            } else {
                $error = "Error marking attendance: " . $stmt->error;
            }
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

</head>
<body>
    <div>
        <div class="login-card">
            <h1>Mark Attendance</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if (!empty($success)) { echo "<p style='color: green;'>$success</p>"; } ?>
            <form method="POST" action="dashboard.php">
                <input type="hidden" style="display: none;" name="employee_id" value="<?php echo htmlspecialchars(string: $employee_id); ?>">
                <input type="hidden" name="date" value="<?php echo htmlspecialchars($today); ?>">
                <?php echo  $employee_id; ?>
                <select name="status" class="glass-input" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
                <button class="btn" type="submit">Mark Attendance</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>