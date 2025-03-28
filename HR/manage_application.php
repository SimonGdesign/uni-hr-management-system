<?php
session_start();
require '../db_connection.php';

// Fetch all job applications
$query = "SELECT * FROM applications WHERE status='Under Review'";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications</title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <div class="container">
        <h1>Manage Job Applications</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Resume</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($app = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($app['applicant_name']) ?></td>
                        <td><?= htmlspecialchars($app['email']) ?></td>
                        <td><?= htmlspecialchars($app['phone_number']) ?></td>
                        <td><a href="<?= htmlspecialchars($app['resume']) ?>" target="_blank">View Resume</a></td>
                        <td>
                            <form action="update_application_status.php" method="POST" style="display:inline;">
                                <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
                                <input type="hidden" name="applicant_name" value="<?= htmlspecialchars($app['applicant_name']) ?>">
                                <input type="hidden" name="email" value="<?= htmlspecialchars($app['email']) ?>">
                                <input type="hidden" name="phone_number" value="<?= htmlspecialchars($app['phone_number'] ?? '') ?>">
                                <button type="submit" name="action" value="approve" class="btn">Approve</button>
                                <button type="submit" name="action" value="reject" class="btn-reject">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
