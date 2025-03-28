<?php
session_start();
require '../db_connection.php';

// Restrict access to admin users
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Initialize messages
$error = $_SESSION['error'] ?? "";
$success = $_SESSION['success'] ?? "";

// Clear session messages after displaying
unset($_SESSION['error']);
unset($_SESSION['success']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'] ?? '';
    $award_name = $_POST['award_name'] ?? '';
    $date = $_POST['date'] ?? '';
    $description = $_POST['description'] ?? '';

    if (!empty($employee_id) && !empty($award_name) && !empty($date) && !empty($description)) {
        $query = "INSERT INTO awards (employee_id, award_name, date, description) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isss", $employee_id, $award_name, $date, $description);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Award added successfully!";
            header("Location: dashboard.php?section=awards");
            exit();
        } else {
            $_SESSION['error'] = "Error adding award: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Award</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Add Award</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if (!empty($success)) { echo "<p style='color: green;'>$success</p>"; } ?>
            
            <form method="POST" action="add_award.php">
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
                <input type="text" name="award_name" class="glass-input" placeholder="Award Name" required>
                <input type="date" name="date" class="glass-input" required>
                <textarea name="description" class="glass-input" placeholder="Description" required></textarea>
                <button class="btn" type="submit">Add Award</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); // Closing connection at the end ?>
