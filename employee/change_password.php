<?php
include("../db_connection.php");
session_start();

if (!isset($_SESSION["email"])) {
    die("Unauthorized access.");
}

$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        die("Error: New passwords do not match.");
    }

    // Retrieve the current password hash from the database
    $sql = "SELECT password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Database error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the current password
        if (!password_verify($current_password, $hashed_password)) {
            die("Error: Current password is incorrect.");
        }

        // Hash the new password
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $update_sql = "UPDATE users SET password = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_sql);
        if (!$update_stmt) {
            die("Database error: " . $conn->error);
        }

        $update_stmt->bind_param("ss", $new_hashed_password, $email);

        if ($update_stmt->execute()) {
            echo "<p style='text-align:center;'>Password changed successfully.<p>";
           exit();
        } else {
            echo "<p style='text-align:center;'>Error updating password.<P>";
            exit();
        }
    } else {
        echo "User not found.";
    }

    // Close statements
    $stmt->close();
    $update_stmt->close();
    $conn->close();
}
?>
