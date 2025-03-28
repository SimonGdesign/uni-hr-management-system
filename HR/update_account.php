<?php
session_start();
require '../db_connection.php';

$error = "";
$success = "";

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    $error = "User is not logged in.";
} else {
    $user_id = $_SESSION['user_id'];  // Assuming user_id is stored in session

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        if (!empty($full_name) && !empty($email) && !empty($phone)) {
            $query = "UPDATE users SET full_name = ?, email = ?, phone = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $full_name, $email, $phone, $user_id);
            if ($stmt->execute()) {
                $success = "Profile updated successfully.";
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
    <title>Update Account</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Update Account</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if (!empty($success)) { echo "<p style='color: green;'>$success</p>"; } ?>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>