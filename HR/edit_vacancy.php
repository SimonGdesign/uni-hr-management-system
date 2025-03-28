<?php
session_start();
require '../db_connection.php';

$listing_id = $_GET['id'] ?? '';
$job = null;

if (!empty($listing_id)) {
    $query = "SELECT * FROM joblistings WHERE listing_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $listing_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
    }
    $stmt->close();
}

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $department = $_POST['department'] ?? '';
    $description = $_POST['description'] ?? '';

    // Validate form data
    if (!empty($title) && !empty($department) && !empty($description)) {
        // Update job listing
        $query = "UPDATE job_listings SET title = ?, department = ?, description = ? WHERE listing_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $title, $department, $description, $listing_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?section=job_listings&success=Job listing updated successfully");
            exit;
        } else {
            $error = "Error updating job listing: " . $stmt->error;
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
    <title>Edit Job Listing</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Edit Job Listing</h1>
            <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <?php if ($job): ?>
                <form method="POST" action="edit_vacancy.php?id=<?php echo htmlspecialchars($listing_id); ?>">
                    <input type="text" name="title" class="glass-input" placeholder="Title" value="<?php echo htmlspecialchars($job['title']); ?>" required>
                    <select name="department" class="glass-input" required>
                        <option value="">Select Department</option>
                        <?php
                        $query = "SELECT name FROM departments";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['name']) . '"' . ($row['department'] == $row['name'] ? ' selected' : '') . '>' . htmlspecialchars($row['name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <textarea name="description" class="glass-input" placeholder="Description" required><?php echo htmlspecialchars($job['description']); ?></textarea>
                    <button class="btn" type="submit">Update Job Listing</button>
                </form>
            <?php else: ?>
                <p>Job listing not found.</p>
            <?php endif; ?>
            <a href="dashboard.php" class="btn" style="margin-top: 1rem;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>