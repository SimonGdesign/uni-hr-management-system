<?php
session_start();
require '../db_connection.php';
include 'fetch_announcements.php';
include 'fetch_job_listings.php';
include 'fetch_attendance.php';
include 'fetch_leave.php';
include 'fetch_payroll.php';
include 'fetch_awards.php';
include 'fetch_account.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../index.php");
    exit();
}

$error = "";
$success = "";

$email = $_SESSION['email'];  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);

    if (!empty($full_name) && !empty($phone)) {
        $query = "UPDATE employees SET full_name = ?, phone = ? WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $full_name, $phone, $email);

        if ($stmt->execute()) {
            $success = "Profile updated successfully.";
        } else {
            $error = "Error updating profile: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "All fields are required.";
    }
    

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Luxury Dashboard -->
    <div id="dashboard">
        <header class="header">
            <div class="logo">UHRMS</div>
            <a href="../auth/out.php" style='text-decoration:none;' class="btn" style="background: var(--accent);">🚪 Logout</a>
        </header>

        <div class="dashboard">
            <nav class="sidebar">
                <div class="nav-item" onclick="showSection('announcements')">📢 Announcements</div>
                <div class="nav-item" onclick="showSection('recruitment')">💼 Job listings</div>
                <div class="nav-item" onclick="showSection('attendance')">📅 Attendance</div>
                <div class="nav-item" onclick="showSection('leave')">🌴 Leave</div>
                <div class="nav-item" onclick="showSection('payroll')">💰 Payroll</div>
                <div class="nav-item" onclick="showSection('awards')">🏆 Awards</div>
                <div class="nav-item" onclick="showSection('account')">👤 Account</div>
            </nav>

            <!-- Content Sections -->
            <div class="content">
                <!-- Announcements Section -->
                <div id="announcements" class="section active">
                    <h2 style="color: white; margin-bottom: 2rem;">Latest Updates</h2>
                    <?php if (!empty($announcements)): ?>
                        <?php foreach ($announcements as $announcement): ?>
                            <div class="card announcement-card" style="margin-top: 1.5rem;">
                                <h3 style="color: var(--primary);"><?php echo htmlspecialchars($announcement['title']); ?></h3>
                                <p style="margin: 1rem 0; color: #666;">Date: <?php echo htmlspecialchars($announcement['created_at']); ?></p>
                                <p><?php echo nl2br(htmlspecialchars($announcement['content'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No announcements found.</p>
                    <?php endif; ?>
                </div>

                <!-- Job Listings Section -->
                <div id="recruitment" class="section">
                    <div class="card">
                        <div class="tab-nav">
                            <button class="tab-btn active" onclick="showTab('vacancies')">Vacancies</button>
                        </div>
                        <div id="vacancies" class="tab-content active">
                            <?php if (!empty($job_listings)): ?>
                                <?php foreach ($job_listings as $job): ?>
                                    <div class="card announcement-card">
                                        <h3 style="color: var(--primary);"><?php echo htmlspecialchars($job['title']); ?></h3>
                                        <p style="margin: 1rem 0; color: #666;">Department: <?php echo htmlspecialchars($job['department']); ?></p>
                                        <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No job listings found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Attendance Section -->
                <div id="attendance" class="section">
                    
                        <?php include 'mark_attendance.php'?>
                </div>

                <!-- Leave Section -->
                <div id="leave" class="section">
                    <div class="card">
                        <table class="employee-table">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Leave Type</th>
                                    <th>Dates</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($leave_data)): ?>
                                    <?php foreach ($leave_data as $leave): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($leave['employee_id']); ?></td>
                                            <td><?php echo htmlspecialchars($leave['leave_type']); ?></td>
                                            <td><?php echo htmlspecialchars($leave['start_date']); ?> to <?php echo htmlspecialchars($leave['end_date']); ?></td>
                                            <td><?php echo htmlspecialchars($leave['status']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No leave records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="../employee/leave_request.php" class="btn" style="margin-top: 1rem; text-decoration: none;">➕ New Leave Request</a>
                    </div>
                </div>

                <!-- Payroll Section -->
                <div id="payroll" class="section">
                    <div class="card">
                        <div class="tab-nav">
                            <button class="tab-btn" onclick="showTab('payslipList')">History</button>
                        </div>
                        <div id="payslipList" class="tab-content">
                            <table class="employee-table">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Employee ID</th>
                                        <th>Basic Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($payroll_data)): ?>
                                        <?php foreach ($payroll_data as $payroll): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($payroll['month']); ?></td>
                                                <td><?php echo htmlspecialchars($payroll['employee_id']); ?></td>
                                                <td><?php echo htmlspecialchars($payroll['basic_salary']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3">No payroll records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <!-- Awards Section -->
            <div id="awards" class="section">
                    <div class="card">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Employee Awards</h3>
                        </div>
                        <div class="card announcement-card" style="margin-top: 1rem;">
                            <?php if (!empty($awards_data)): ?>
                                <?php foreach ($awards_data as $award): ?>
                                    <h4><?php echo htmlspecialchars($award['award_name']); ?> - <?php echo htmlspecialchars($award['date']); ?></h4>
                                    <p>Awarded to: <?php echo htmlspecialchars($award['employee_id']); ?></p>
                                    <p><?php echo htmlspecialchars($award['description']); ?></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No awards found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Account Settings Section -->
                <div id="account" class="section">
                    <div class="card">
                        <div class="tab-nav">
                            <button class="tab-btn active" onclick="showTab('editProfile')">Profile</button>
                            <button class="tab-btn" onclick="showTab('changePassword')">Password</button>
                        </div>
                        <div id="editProfile" class="tab-content active">
                            <form class="form-grid" method="post" action="dashboard.php">
                                <input type="text" name="full_name" placeholder="Full Name" value="<?php echo htmlspecialchars($account_data['full_name']); ?>" required>
                                <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($account_data['email']); ?>" readonly required>
                                <input type="tel" name="phone" placeholder="Phone" value="<?php echo htmlspecialchars($account_data['phone']); ?>" required>
                                <button class="btn" type="submit">Update Profile</button>
                            
                            </form>
                        </div>
                        <div id="changePassword" class="tab-content">
                            <form class="form-grid" method="POST" action="change_password.php">
                                <input type="password" name="current_password" placeholder="Current Password" required>
                                <input type="password" name="new_password" placeholder="New Password" required>
                                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                                <button class="btn" type="submit">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../js/script.js"></script>
</body>
</html>