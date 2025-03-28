```php name=add_employee.php
<?php
session_start();
require '../db_connection.php';

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $role = $_POST['role'] ?? '';
    $department = $_POST['department'] ?? '';

    // Validate form data
    if (!empty($full_name) && !empty($role) && !empty($department)) {
        // Insert new employee
        $query = "INSERT INTO employees (full_name, role, department) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $full_name, $role, $department);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=employees&success=Employee added successfully");
            exit;
        } else {
            $error = "Error adding employee: " . $stmt->error;
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
    <title>Add Employee</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Add Employee</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="POST" action="add_employee.php">
                <input type="text" name="full_name" class="glass-input" placeholder="Full Name" required>
                <input type="text" name="role" class="glass-input" placeholder="Role" required>
                <select name="department" class="glass-input" required>
                    <option value="">Select Department</option>
                    <?php
                    $query = "SELECT name FROM departments";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['name']) . '">' . htmlspecialchars($row['name']) . '</option>';
                        }
                    }
                    ?>
                </select>
                <button class="btn" type="submit">Add Employee</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>