<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['employee_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$account_id = $_SESSION['employee_id'];
$account = null;

$query = "SELECT * FROM accounts WHERE employee_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $account_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $account = $result->fetch_assoc();
}
$stmt->close();

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate form data
    if (!empty($username) && !empty($email)) {
        // Update account
        $query = "UPDATE accounts SET username = ?, email = ? WHERE employee_id = ?";
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = "UPDATE accounts SET username = ?, email = ?, password = ? WHERE employee_id = ?";
        }
        $stmt = $conn->prepare($query);
        if (!empty($password)) {
            $stmt->bind_param("sssi", $username, $email, $hashed_password, $account_id);
        } else {
            $stmt->bind_param("ssi", $username, $email, $account_id);
        }

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=account&success=Account updated successfully");
            exit;
        } else {
            $error = "Error updating account: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Username and Email are required.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Edit Account</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if ($account): ?>
                <form method="POST" action="edit_account.php">
                    <input type="text" name="username" class="glass-input" value="<?php echo htmlspecialchars($account['username']); ?>" required>
                    <input type="email" name="email" class="glass-input" value="<?php echo htmlspecialchars($account['email']); ?>" required>
                    <input type="password" name="password" class="glass-input" placeholder="New Password (optional)">
                    <button class="btn" type="submit">Update Account</button>
                </form>
            <?php else: ?>
                <p>Account not found.</p>
            <?php endif; ?>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>