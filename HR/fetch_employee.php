<?php
require '../db_connection.php';

$employees = [];
$query = "SELECT e.employee_id, e.full_name, e.role, d.name AS department
          FROM employees e
          LEFT JOIN departments d ON e.department_id = d.department_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
} else {
    $employees = null;
}
?>