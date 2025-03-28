<?php
require '../db_connection.php';

$account_data = [];
$email = $_SESSION['email'];  // Assuming user_id is stored in session
$query = "SELECT full_name, email, phone FROM employees WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $account_data = $result->fetch_assoc();
} else {
    $account_data = null;
}
?>