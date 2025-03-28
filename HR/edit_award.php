<?php
session_start();
require '../db_connection.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
$award_id = $_GET['id'] ?? '';
$award = null;

if (!empty($award_id)) {
    $query = "SELECT * FROM awards WHERE award_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $award_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $award = $result->fetch_assoc();
    }
    $stmt->close();
}

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $award_name = $_POST['award_name'] ?? '';
    $date = $_POST['date'] ?? '';
    $description = $_POST['description'] ?? '';

    // Validate form data
    if (!empty($award_name) && !empty($date) && !empty($description)) {
        // Update award
        $query = "UPDATE awards SET award_name = ?, date = ?, description = ? WHERE award_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $award_name, $date, $description, $award_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=awards&success=Award updated successfully");
            exit;
        } else {
            $error = "Error updating award: " . $stmt->error;
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
    <title>Edit Award</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Edit Award</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if ($award): ?>
                <form method="POST" action="edit_award.php?id=<?php echo htmlspecialchars($award_id); ?>">
                    <input type="text" name="award_name" class="glass-input" value="<?php echo htmlspecialchars($award['award_name']); ?>" required>
                    <input type="date" name="date" class="glass-input" value="<?php echo htmlspecialchars($award['date']); ?>" required>
                    <textarea name="description" class="glass-input" required><?php echo htmlspecialchars($award['description']); ?></textarea>
                    <button class="btn" type="submit">Update Award</button>
                </form>
            <?php else: ?>
                <p>Award not found.</p>
            <?php endif; ?>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>