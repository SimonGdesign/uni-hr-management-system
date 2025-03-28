<?php
session_start();
require '../db_connection.php';

$error = "";
$success = "";

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    $error = "User is not logged in.";
    $account_data = null;
} else {
    $account_data = [];
    $user_id = $_SESSION['user_id'];  // Assuming user_id is stored in session
    $query = "SELECT full_name, email, phone FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $account_data = $result->fetch_assoc();
    } else {
        $account_data = null;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        if (!empty($full_name) && !empty($email) && !empty($phone)) {
            $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ? WHERE user_id = ?");
            $stmt->bind_param("sssi", $full_name, $email, $phone, $user_id);
            if ($stmt->execute()) {
                $success = "Profile updated successfully.";
                // Refresh account data
                $account_data['full_name'] = $full_name;
                $account_data['email'] = $email;
                $account_data['phone'] = $phone;
            } else {
                $error = "Error updating profile: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "All fields are required.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Account</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Manage Account</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if (!empty($success)) { echo "<p style='color: green;'>$success</p>"; } ?>
            <?php if ($account_data): ?>
                <form method="POST" action="manage_account.php">
                    <input type="text" name="full_name" placeholder="Full Name" value="<?php echo htmlspecialchars($account_data['full_name']); ?>" required>
                    <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($account_data['email']); ?>" required>
                    <input type="tel" name="phone" placeholder="Phone" value="<?php echo htmlspecialchars($account_data['phone']); ?>" required>
                    <button type="submit" class="btn">Update Profile</button>
                </form>
            <?php else: ?>
                <p>User data not found.</p>
            <?php endif; ?>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>