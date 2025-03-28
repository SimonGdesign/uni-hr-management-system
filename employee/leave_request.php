<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit;
}
$email = $_SESSION['email'];

$sql = "SELECT employee_id FROM employees WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($employee_id);
$stmt->fetch();
$stmt->close();
var_dump($_SESSION) ;
$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_type = $_POST['leave_type'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $reason = $_POST['reason'] ?? '';

    // Validate form data
    if (!empty($leave_type) && !empty($start_date) && !empty($end_date) && !empty($reason)) {
        // Insert new leave request
        $query = "INSERT INTO leaverequests (employee_id, leave_type, start_date, end_date, reason) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issss", $employee_id, $leave_type, $start_date, $end_date, $reason);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=leave&success=Leave request submitted successfully");
            exit;
        } else {
            $error = "Error submitting leave request: " . $stmt->error;
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
    <title>Request Leave</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Request Leave</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="POST" action="">
             <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars(string: $employee_id); ?>">

                <select name="leave_type" class="glass-input" required>
                    <option value="">Select Leave Type</option>
                    <option value="Sick Leave">Sick Leave</option>
                    <option value="Casual Leave">Casual Leave</option>
                    <option value="Annual Leave">Annual Leave</option>
                </select>
                <input type="date" name="start_date" class="glass-input" required>
                <input type="date" name="end_date" class="glass-input" required>
                <textarea name="reason" class="glass-input" placeholder="Reason" required></textarea>
                <button class="btn" type="submit">Submit Leave Request</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>