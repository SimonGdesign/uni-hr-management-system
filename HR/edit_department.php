```php name=edit_department.php
<?php
session_start();
require '../db_connection.php';

$department_id = $_GET['id'] ?? '';
$department = null;

if (!empty($department_id)) {
    $query = "SELECT * FROM departments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $department_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $department = $result->fetch_assoc();
    }
    $stmt->close();
}

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $head = $_POST['head'] ?? '';

    // Validate form data
    if (!empty($name) && !empty($head)) {
        // Update department
        $query = "UPDATE departments SET name = ?, head = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $name, $head, $department_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=departments&success=Department updated successfully");
            exit;
        } else {
            $error = "Error updating department: " . $stmt->error;
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
    <title>Edit Department</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Edit Department</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if ($department): ?>
                <form method="POST" action="edit_department.php?id=<?php echo htmlspecialchars($department_id); ?>">
                    <input type="text" name="name" class="glass-input" placeholder="Department Name" value="<?php echo htmlspecialchars($department['name']); ?>" required>
                    <input type="text" name="head" class="glass-input" placeholder="Department Head" value="<?php echo htmlspecialchars($department['head']); ?>" required>
                    <button class="btn" type="submit">Update Department</button>
                </form>
            <?php else: ?>
                <p>Department not found.</p>
            <?php endif; ?>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>