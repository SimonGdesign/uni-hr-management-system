<?php

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
require '../db_connection.php';
include 'fetch_announcements.php';
include 'fetch_departments.php';
include 'fetch_employee.php';
include 'fetch_job_listings.php';
include 'fetch_job_applications.php';
include 'fetch_attendance.php';
include 'fetch_leave.php';
include 'fetch_payroll.php';
include 'fetch_awards.php';
include 'fetch_account.php';
if (!isset($_SESSION["email"])) {
    header("Location: ../index.php");
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
    <div id="dashboard">
        <header class="header">
            <div class="logo">UHRMS</div>
            <a href="../auth/out.php" style='text-decoration:none;' class="btn" style="background: var(--accent);">🚪 Logout</a>
        </header>

        <div class="dashboard">
            <nav class="sidebar">
                <div class="nav-item" onclick="showSection('announcements')">📢 Announcements</div>
                <div class="nav-item" onclick="showSection('departments')">🏛 Departments</div>
                <div class="nav-item" onclick="showSection('employees')">✨ Employees</div>
                <div class="nav-item" onclick="showSection('job_listings')">💼 Job listings</div>
                <div class="nav-item" onclick="showSection('job_applications')">📄  Job Applications</div>
                <div class="nav-item" onclick="showSection('attendance')">📅 Attendance</div>
                <div class="nav-item" onclick="showSection('leave')">🌴 Leave</div>
                <div class="nav-item" onclick="showSection('payroll')">💰 Payroll</div>
                <div class="nav-item" onclick="showSection('awards')">🏆 Awards</div>
                <div class="nav-item" onclick="showSection('account')">👤 My Account</div>
            </nav>

            <!-- Content Sections -->
            <div class="content">
                <!-- Announcements Section -->
<div id="announcements" class="section active">
    <h2 style="color: white; margin-bottom: 2rem; text-align: center;">Latest Updates</h2>
    
    <?php if (!empty($announcements)): ?>
        <?php foreach ($announcements as $announcement): ?>
            <div class="card announcement-card" style="margin-top: 1.5rem; padding: 1.5rem; border-radius: 10px; background: rgba(255, 255, 255, 0.9); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                <h3 style="color: var(--primary); margin-bottom: 0.5rem;"><?php echo htmlspecialchars($announcement['title']); ?></h3>
                <p style="margin: 0.5rem 0; color: #666;">Date: <?php echo htmlspecialchars($announcement['created_at']); ?></p>
                <p style="margin-bottom: 1rem;"><?php echo nl2br(htmlspecialchars($announcement['content'])); ?></p>
                
                <!-- Button container for proper spacing -->
                <div style="display: flex; gap: 10px; margin-top: 1rem;">
                    <a href="edit_announcement.php?id=<?php echo $announcement['announcement_id']; ?>" class="btn" style="background-color: #007bff; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none;">Edit</a>
                    <a href="delete_announcement.php?id=<?php echo $announcement['announcement_id']; ?>" class="btn" style="background-color: #dc3545; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none;" onclick="return confirm('Are you sure you want to delete this announcement?');">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center; color: white;">No announcements found.</p>
    <?php endif; ?>

    <a class="btn" href="add_announcement.php" style="display: block; width: fit-content; margin: 20px auto; background-color: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">📢 New Announcement</a>
</div>


                <!-- Departments Section -->
                <div id="departments" class="section">
                    <h2 style="color: white; margin-bottom: 2rem;">Departments</h2>
                    
                    <?php if (!empty($departments)): ?>
                        <table class="employee-table">
                            <thead>
                                <tr>
                                    <th>Department Name</th>
                                    <th>Head</th>
                                    <th>Members</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($departments as $department): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($department['name']); ?></td>
                                        <td><?php echo htmlspecialchars($department['head']); ?></td>
                                        <td><?php echo htmlspecialchars($department['members']); ?></td>
                                        <td>
                                            <a href="edit_department.php?id=<?php echo $department['department_id']; ?>" class="btn">Edit</a>
                                            <a href="delete_department.php?id=<?php echo $department['department_id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this department?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No departments found.</p>
                    <?php endif; ?>

                    <a class="btn" href="add_department.php">🏛 Add Department</a>
                </div>

                <!-- Employees Section -->
                <div id="employees" class="section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                        <h2 style="color: white;">Employee List</h2>
                        <a href='add_employee.php' class="btn" style='text-decoration:none;'>➕ Add employee</a>
                    </div>
                    <table class="employee-table">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Department</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($employees)): ?>
                                <?php foreach ($employees as $employee): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['role']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['department']); ?></td>
                                        <td>
                                            <a href="view_employee.php?id=<?php echo $employee['employee_id']; ?>" class="btn">View</a>
                                            <a href="edit_employee.php?id=<?php echo $employee['employee_id']; ?>" class="btn">Edit</a>
                                            <a href="delete_employee.php?id=<?php echo $employee['employee_id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No employees found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

               <!-- Job Listings Section -->
<div id="job_listings" class="section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="color: white;">Job Listings</h2>
        <a href='add_vacancy.php' class="btn" style='text-decoration:none;'>➕ Add Job Listing</a>
    </div>
    <table class="employee-table">
        <thead>
            <tr>
                <th>Listing ID</th>
                <th>Title</th>
                <th>Department</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($job_listings)): ?>
                <?php foreach ($job_listings as $job): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($job['listing_id']); ?></td>
                        <td><?php echo htmlspecialchars($job['title']); ?></td>
                        <td><?php echo htmlspecialchars($job['department']); ?></td>
                        <td><?php echo htmlspecialchars($job['description']); ?></td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <a href="view_job.php?id=<?php echo $job['listing_id']; ?>" class="btn">View</a>
                                <a href="edit_vacancy.php?id=<?php echo $job['listing_id']; ?>" class="btn">Edit</a>
                                <a href="delete_vacancy.php?id=<?php echo $job['listing_id']; ?>" class="btn" 
                                    onclick="return confirm('Are you sure you want to delete this job listing?');">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No job listings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- Job Applications Section -->
<div id="job_applications" class="section">
    <h2 style="color: white; margin-bottom: 2rem;">Job Applications</h2>
    <table class="employee-table">
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
            <?php if (!empty($job_applications)): ?>
                <?php foreach ($job_applications as $application): ?>
                    <tr>
                        <td><?= htmlspecialchars($application['applicant_name'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($application['email'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($application['phone_number'] ?? 'N/A') ?></td>
                        <td><button style="background-color: #4CAF50; color: white; padding: 10px 20px; margin: 5px; border: none; cursor: pointer; border-radius: 5px;" onclick="viewResume(<?= htmlspecialchars(json_encode($application['resume'] ?? 'N/A')) ?>)">View Resume</button></td>
                        <td>
                            <form method="POST" action="process_application.php">
                                <input type="hidden" name="application_id" value="<?= $application['application_id'] ?>">
                                <button type="submit" name="action" value="approve" style="background-color: #008CBA; color: white; padding: 10px 20px; margin: 5px; border: none; cursor: pointer; border-radius: 5px;">Approve</button>
                                <button type="submit" name="action" value="reject" style="background-color: #f44336; color: white; padding: 10px 20px; margin: 5px; border: none; cursor: pointer; border-radius: 5px;">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No job applications found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Resume Modal -->
<div id="resumeModal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4); padding-top: 60px;">
    <div style="background-color: #fefefe; margin: 5% auto; padding: 20px; border: 1px solid #888; width: 80%; border-radius: 10px;">
        <span style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;" onclick="closeResumeModal()">&times;</span>
        <h2>Resume Details</h2>
        <div id="resumeContent"></div>
    </div>
</div>

<script>
function viewResume(resumeContent) {
    document.getElementById('resumeContent').innerText = resumeContent;
    document.getElementById('resumeModal').style.display = 'block';
}

function closeResumeModal() {
    document.getElementById('resumeModal').style.display = 'none';
}
</script>
                <!-- Attendance Section -->
                <div id="attendance" class="section">
                    <div class="card">
                        <h2 style="color: black; margin-bottom: 2rem;">Attendance Records</h2>
                        <table class="employee-table">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($attendance)): ?>
                                    <?php foreach ($attendance as $record): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($record['employee_id']); ?></td>
                                            <td><?php echo htmlspecialchars($record['date']); ?></td>
                                            <td><?php echo htmlspecialchars($record['status']); ?></td>
                                            <td><?php echo htmlspecialchars($record['timestamp']); ?></td>
                                            <?php if (isset($_SESSION['admin'])): ?>
                                            <td>
                                                <a href="edit_attendance.php?id=<?php echo $record['attendance_id']; ?>" class="btn">Edit</a>
                                                <a href="delete_attendance.php?id=<?php echo $record['attendance_id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this attendance record?');">Delete</a>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">No attendance records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Leave Management Section -->
                <div id="leave" class="section">
                    <div class="card">
                        <table class="employee-table">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Leave Type</th>
                                    <th>Dates</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
                                            <td>
                                                <form action="update_leave.php" method="POST">
                                                    <input type="hidden" name="leave_id" value="<?php echo htmlspecialchars($leave['employee_id']); ?>">
                                                    <select name="status" required>
                                                        <option value="">Select Status</option>
                                                        <option value="Approved">Approve</option>
                                                        <option value="Rejected">Reject</option>
                                                    </select>
                                                    <button type="submit" class="btn">Submit</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">No leave records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Payroll Section -->
                <div id="payroll" class="section">
                    <div class="card">
                        <div class="tab-nav">
                            <button class="tab-btn active" onclick="showTab('createPayslip')">Create</button>
                            <button class="tab-btn" onclick="showTab('payslipList')">History</button>
                        </div>

                        <div id="createPayslip" class="tab-content active">
                            <form class="form-grid" action="process_payslip.php" method="POST">
                                <select name="employee_id" class="glass-input" required>
                                    <option value="">Select Employee</option>
                                    <?php if (!empty($employees)): ?>
                                        <?php foreach ($employees as $employee): ?>
                                            <option value="<?php echo htmlspecialchars($employee['employee_id']); ?>"><?php echo htmlspecialchars($employee['full_name']); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                                <input type="number" name="basic_salary" placeholder="Basic Salary" class="glass-input" required>
                                <input type="number" name="allowances" placeholder="Allowances" class="glass-input" required>
                                <input type="number" name="deductions" placeholder="Deductions" class="glass-input" required>
                                <input type="text" name="month" placeholder="Month" class="glass-input" required>
                                <button class="btn" type="submit">Generate Payslip</button>
                            </form>
                        </div>

                        <div id="payslipList" class="tab-content">
                            <table class="employee-table">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Employee</th>
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
                            <a class="btn" href="add_award.php">🏆 New Award</a>
                        </div>
                        <div class="card announcement-card" style="margin-top: 1rem;">
                            <?php if (!empty($awards_data)): ?>
                                <?php foreach ($awards_data as $award): ?>
                                    <h4><?php echo htmlspecialchars($award['award_name']); ?> - <?php echo htmlspecialchars($award['date']); ?></h4>
                                    <p>Awarded to: <?php echo htmlspecialchars($award['employee_id']); ?></p>
                                    <p><?php echo htmlspecialchars($award['description']); ?></p>
                                    <a href="edit_award.php?id=<?php echo $award['employee_id']; ?>" class="btn">Edit</a>
                                    <a href="delete_awards.php?id=<?php echo $award['employee_id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this award?');">Delete</a>
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

               

    <script src="../js/script.js"></script>
</body>
</html>