```php name=edit_announcement.php
<?php
session_start();
require '../db_connection.php';

$announcement_id = $_GET['announcement_id'] ?? '';
$announcement = null;

if (!empty($announcement_id)) {
    $query = "SELECT * FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $announcement_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $announcement = $result->fetch_assoc();
    }
    $stmt->close();
}

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    // Validate form data
    if (!empty($title) && !empty($content)) {
        // Update announcement
        $query = "UPDATE announcements SET title = ?, content = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $title, $content, $announcement_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=announcements&success=Announcement updated successfully");
            exit;
        } else {
            $error = "Error updating announcement: " . $stmt->error;
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
    <title>Edit Announcement</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Edit Announcement</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if ($announcement): ?>
                <form method="POST" action="edit_announcement.php?id=<?php echo htmlspecialchars($announcement_id); ?>">
                    <input type="text" name="title" class="glass-input" placeholder="Title" value="<?php echo htmlspecialchars($announcement['title']); ?>" required>
                    <textarea name="content" class="glass-input" placeholder="Content" required><?php echo htmlspecialchars($announcement['content']); ?></textarea>
                    <button class="btn" type="submit">Update Announcement</button>
                </form>
            <?php else: ?>
                <p>Announcement not found.</p>
            <?php endif; ?>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>