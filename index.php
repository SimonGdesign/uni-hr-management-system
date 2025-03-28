<?php
session_start();
require 'db_connection.php'; 
 
if(isset($_SESSION['email'])) {
    header("Location: ./HR/dashboard.php");
    exit;
}

$error = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']); 
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT user_id, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                if ($user['role'] == 'admin') {
                    $_SESSION['email'] = $user['email']; 
                    $_SESSION['role'] = $user['role']; 
                    header("Location: ./HR/dashboard.php");
                } else {
                    $_SESSION['email'] = $user['email']; 
                    $_SESSION['role'] = $user['role']; 
                    header("Location: ./employee/dashboard.php");
                }
                exit;
            } else {
                $error = "Invalid credentials. Please try again.";
            }
        } else {
            $error = "User not found.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <h1 style ='margin-bottom:10px;' >UHRMS <br> Login</h1>
            
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn">Access Dashboard</button>
            </form>
        </div>
    </div>

</body>
</html>
