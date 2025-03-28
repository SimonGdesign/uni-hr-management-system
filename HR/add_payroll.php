<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit;
}

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'] ?? '';
    $month = $_POST['month'] ?? '';
    $basic_salary = $_POST['basic_salary'] ?? '';
    $allowances = $_POST['allowances'] ?? '';
    $deductions = $_POST['deductions'] ?? '';

    // Validate form data
    if (!empty($employee_id) && !empty($month) && !empty($basic_salary) && !empty($allowances) && !empty($deductions)) {
        // Calculate net salary
        $net_salary = $basic_salary + $allowances - $deductions;

        // Insert new payroll record
        $query = "INSERT INTO payslip (employee_id, month, basic_salary, allowances, deductions, net_salary) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isdddd", $employee_id, $month, $basic_salary, $allowances, $deductions, $net_salary);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=payroll&success=Payroll record added successfully");
            exit;
        } else {
            $error = "Error adding payroll record: " . $stmt->error;
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
    <title>Add Payroll Record</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Add Payroll Record</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="POST" action="add_payroll.php">
                <select name="employee_id" class="glass-input" required>
                    <option value="">Select Employee</option>
                    <?php
                    $query = "SELECT employee_id, full_name FROM employees";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['employee_id']) . '">' . htmlspecialchars($row['full_name']) . '</option>';
                        }
                    }
                    ?>
                </select>
                <input type="text" name="month" class="glass-input" placeholder="Month" required>
                <input type="number" name="basic_salary" class="glass-input" placeholder="Basic Salary" required>
                <input type="number" name="allowances" class="glass-input" placeholder="Allowances" required>
                <input type="number" name="deductions" class="glass-input" placeholder="Deductions" required>
                <button class="btn" type="submit">Add Payroll Record</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>