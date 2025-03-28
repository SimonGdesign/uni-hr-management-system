<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <meta http-equiv="refresh" content="1;url=../index.php">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .message {
            text-align: center;
            font-size: 1.5rem;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="message">
        <p>Logging out... Please wait.</p>
    </div>
</body>
</html>
