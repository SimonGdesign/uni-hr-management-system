```php name=edit_employee.php
<?php
session_start();
require '../db_connection.php';

$employee_id = $_GET['id'] ?? '';
$employee = null;

if (!empty($employee_id)) {
    $query = "SELECT * FROM employees WHERE employee_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    }
    $stmt->close();
}

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $role = $_POST['role'] ?? '';
    $department = $_POST['department'] ?? '';

    // Validate form data
    if (!empty($full_name) && !empty($role) && !empty($department)) {
        // Update employee
        $query = "UPDATE employees SET full_name = ?, role = ?, department = ? WHERE employee_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $full_name, $role, $department, $employee_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=employees&success=Employee updated successfully");
            exit;
        } else {
            $error = "Error updating employee: " . $stmt->error;
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
    <title>Edit Employee</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Edit Employee</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if ($employee): ?>
                <form method="POST" action="edit_employee.php?id=<?php echo htmlspecialchars($employee_id); ?>">
                    <input type="text" name="full_name" class="glass-input" placeholder="Full Name" value="<?php echo htmlspecialchars($employee['full_name']); ?>" required>
                    <input type="text" name="role" class="glass-input" placeholder="Role" value="<?php echo htmlspecialchars($employee['role']); ?>" required>
                    <select name="department" class="glass-input" required>
                        <option value="">Select Department</option>
                        <?php
                        $query = "SELECT name FROM departments";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['name']) . '"' . ($row['name'] == $employee['department'] ? ' selected' : '') . '>' . htmlspecialchars($row['name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <button class="btn" type="submit">Update Employee</button>
                </form>
            <?php else: ?>
                <p>Employee not found.</p>
            <?php endif; ?>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>