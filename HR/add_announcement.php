```php name=add_announcement.php
<?php
session_start();
require '../db_connection.php';

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    // Validate form data
    if (!empty($title) && !empty($content)) {
        // Insert new announcement
        $query = "INSERT INTO announcements (title, content, created_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $title, $content);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=announcements&success=Announcement added successfully");
            exit;
        } else {
            $error = "Error adding announcement: " . $stmt->error;
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
    <title>Add Announcement</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Add Announcement</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <form method="POST" action="add_announcement.php">
                <input type="text" name="title" class="glass-input" placeholder="Title" required>
                <textarea name="content" class="glass-input" placeholder="Content" required></textarea>
                <button class="btn" type="submit">Add Announcement</button>
            </form>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>