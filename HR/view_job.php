<?php
require '../db_connection.php';

if (isset($_GET['id'])) {
    $listing_id = $_GET['id'];
    
    $query = "SELECT * FROM joblistings WHERE listing_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $listing_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $job = $result->fetch_assoc();
    $stmt->close();
} else {
    header("Location: dashboard.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Listing</title>
    
    <style>
        /* Center the container */
        body {
            background-image: url('../images/background.jpg'); /* Adjust path */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .job-container {
            width: 50%;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7); /* Dark overlay for readability */
            color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* Heading */
        .job-container h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        /* Job Details */
        .job-container p {
            font-size: 18px;
            margin-bottom: 10px;
            text-align: left;
        }

        /* Back Button */
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #17a2b8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>

    <div class="job-container">
        <h1>Job Listing Details</h1>
        <?php if ($job): ?>
            <p><strong>Listing ID:</strong> <?php echo htmlspecialchars($job['listing_id']); ?></p>
            <p><strong>Title:</strong> <?php echo htmlspecialchars($job['title']); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($job['department']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?></p>
        <?php else: ?>
            <p>Job listing not found.</p>
        <?php endif; ?>
        
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>

</body>
</html>
