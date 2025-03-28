<?php


$error = "";
$success = "";

$email= $_SESSION['email'];  // Assuming user_id is stored in session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (!empty($full_name) && !empty($email) && !empty($phone)) {
        $query = "UPDATE employees SET full_name = ?, email = ?, phone = ? WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $full_name, $email, $phone, $email);
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

$conn->close();
?>
