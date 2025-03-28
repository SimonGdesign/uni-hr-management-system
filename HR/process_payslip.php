<?php
session_start();
require '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $basic_salary = $_POST['basic_salary'];
    $allowances = $_POST['allowances'];
    $deductions = $_POST['deductions'];
    $month = $_POST['month'];

    $net_salary = ($basic_salary+ $allowances)-($deductions);

    // Insert payslip into the database
    $stmt = $conn->prepare("INSERT INTO payslips (employee_id, basic_salary, allowances, deductions,month) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("iddds", $employee_id, $basic_salary, $allowances, $deductions, $month);
        if ($stmt->execute()) {
            echo "<script>alert('Payslip generated successfully!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Error generating payslip.'); window.location.href='dashboard.php';</script>";
        }
        $stmt->close();
    } else {
        echo "Database error: " . $conn->error;
    }
}
?>
