<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$payroll_id = $_GET['id'] ?? '';
$payroll = null;

if (!empty($payroll_id)) {
    $query = "SELECT * FROM payslip WHERE payslip_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $payroll_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $payroll = $result->fetch_assoc();
    }
    $stmt->close();
}

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $month = $_POST['month'] ?? '';
    $basic_salary = $_POST['basic_salary'] ?? '';
    $allowances = $_POST['allowances'] ?? '';
    $deductions = $_POST['deductions'] ?? '';

    // Validate form data
    if (!empty($month) && !empty($basic_salary) && !empty($allowances) && !empty($deductions)) {
        // Calculate net salary
        $net_salary = $basic_salary + $allowances - $deductions;

        // Update payroll record
        $query = "UPDATE payslip SET month = ?, basic_salary = ?, allowances = ?, deductions = ?, net_salary = ? WHERE payslip_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sddddi", $month, $basic_salary, $allowances, $deductions, $net_salary, $payroll_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=payroll&success=Payroll record updated successfully");
            exit;
        } else {
            $error = "Error updating payroll record: " . $stmt->error;
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
    <title>Edit Payroll Record</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Edit Payroll Record</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if ($payroll): ?>
                <form method="POST" action="edit_payroll.php?id=<?php echo htmlspecialchars($payroll_id); ?>">
                    <input type="text" name="month" class="glass-input" value="<?php echo htmlspecialchars($payroll['month']); ?>" required>
                    <input type="number" name="basic_salary" class="glass-input" value="<?php echo htmlspecialchars($payroll['basic_salary']); ?>" required>
                    <input type="number" name="allowances" class="glass-input" value="<?php echo htmlspecialchars($payroll['allowances']); ?>" required>
                    <input type="number" name="deductions" class="glass-input" value="<?php echo htmlspecialchars($payroll['deductions']); ?>" required>
                    <button class="btn" type="submit">Update Payroll Record</button>
                </form>
            <?php else: ?>
                <p>Payroll record not found.</p>
            <?php endif; ?>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>