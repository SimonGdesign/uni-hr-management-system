```php name=add_department.php
<?php
session_start();
require '../db_connection.php';

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $head = $_POST['head'] ?? '';

    // Validate form data
    if (!empty($name) && !empty($head)) {
        // Insert new department
        $query = "INSERT INTO departments (name, head) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $name, $head);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=departments&success=Department added successfully");
            exit;
        } else {
            $error = "Error adding department: " . $stmt->error;
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
    <title>Add Department</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Add Department</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="POST" action="add_department.php">
                <input type="text" name="name" class="glass-input" placeholder="Department Name" required>
                <input type="text" name="head" class="glass-input" placeholder="Department Head" required>
                <button class="btn" type="submit">Add Department</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>