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
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';

    // Validate form data
    if (!empty($employee_id) && !empty($username) && !empty($password) && !empty($email) && !empty($role)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new account
        $query = "INSERT INTO accounts (employee_id, username, password, email, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issss", $employee_id, $username, $hashed_password, $email, $role);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=accounts&success=Account added successfully");
            exit;
        } else {
            $error = "Error adding account: " . $stmt->error;
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
    <title>Add Account</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Add Account</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="POST" action="add_account.php">
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
                <input type="text" name="username" class="glass-input" placeholder="Username" required>
                <input type="password" name="password" class="glass-input" placeholder="Password" required>
                <input type="email" name="email" class="glass-input" placeholder="Email" required>
                <select name="role" class="glass-input" required>
                    <option value="">Select Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Employee">Employee</option>
                </select>
                <button class="btn" type="submit">Add Account</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>