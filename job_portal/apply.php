<?php
require '../db_connection.php';

$job_id = $_GET['listing_id'] ?? null;
$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $listing_id = $_POST['listing_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $resume = trim($_POST['resume']);
    
    if (empty($name) || empty($email) || empty($resume)) {
        $error = "All required fields must be filled.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $stmt = $conn->prepare("INSERT INTO applications (applicant_name, listing_id, email, phone_number, resume, status) VALUES (?, ?, ?, ?, ?, 'Under Review')");
        $stmt->bind_param("sisss", $name, $listing_id, $email, $phone, $resume);
        
        if ($stmt->execute()) {
            $success = "Application submitted successfully.";
        } else {
            $error = "Error submitting application.";
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
    <title>Apply for Job</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            text-align: center;
            font-weight: bold;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .btn {
            margin-top: 15px;
            padding: 10px;
            background: #28a745;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #218838;
        }

        .error {
            color: red;
            text-align: center;
        }

        .success {
            color: green;
            text-align: center;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Apply for Job</h1>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p class='success'>$success</p>"; } ?>
        <form method="POST">
            <input type="hidden" name="listing_id" value="<?= htmlspecialchars($job_id) ?>">
            
            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Phone Number:</label>
            <input type="text" name="phone">

            <label>Resume (Paste Link or Summary):</label>
            <textarea name="resume" required></textarea>

            <button type="submit" class="btn">Submit Application</button>
        </form>
    </div>
</body>
</html>
