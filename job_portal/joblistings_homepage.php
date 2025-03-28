<?php
session_start();
require '../db_connection.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UHRMS - Job Portal</title>
    <link rel="stylesheet" href="./css/style.css"> <!-- Ensure this CSS file exists -->
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Gradient background */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        /* Homepage Container */
        .homepage-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        /* Welcome Card */
        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* Button Styling */
        .btn {
            display: inline-block;
            padding: 12px 20px;
            font-size: 16px;
            color: white;
            background: #2575fc;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s ease-in-out;
        }

        .btn:hover {
            background: #1a5fdd;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .welcome-card {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <div class="homepage-container">
        <div class="welcome-card">
            <h1>Welcome to UHRMS</h1>
            <p>Your gateway to exciting career opportunities.</p>
            <a href="job_listings.php" class="btn">View Job Listings</a>
        </div>
    </div>

</body>
</html>
