<?php
session_start();
require '../db_connection.php';

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $department = $_POST['department'] ?? '';
    $description = $_POST['description'] ?? '';

    // Validate form data
    if (!empty($title) && !empty($department) && !empty($description)) {
        // Insert new job listing
        $query = "INSERT INTO job_listings (title, department, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $title, $department, $description);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=job_listings&success=Job listing added successfully");
            exit;
        } else {
            $error = "Error adding job listing: " . $stmt->error;
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
    <title>Add Job Listing</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Add Job Listing</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="POST" action="add_vacancy.php">
                <input type="text" name="title" class="glass-input" placeholder="Title" required>
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
                <textarea name="description" class="glass-input" placeholder="Description" required></textarea>
                <button class="btn" type="submit">Add Job Listing</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>