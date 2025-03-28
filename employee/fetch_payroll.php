<?php
require '../db_connection.php';

$payroll_data = [];
$query = "SELECT employee_id, month, basic_salary FROM payslips";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $payroll_data[] = $row;
    }
} else {
    $payroll_data = null;
}
?>