<?php
session_start();
require '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $application_id = $_POST['application_id'];
    $action = $_POST['action'];
    $applicant_name = $_POST['applicant_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    
    if ($action == 'approve') {
        // Update application status to 'Accepted'
        $stmt = $conn->prepare("UPDATE applications SET status='Accepted' WHERE application_id=?");
        $stmt->bind_param("i", $application_id);
        $stmt->execute();
        $stmt->close();
        
        // Add applicant as an employee
        $stmt = $conn->prepare("INSERT INTO employees (name, email, phone_number, status) VALUES (?, ?, ?, 'Active')");
        $stmt->bind_param("sss", $applicant_name, $email, $phone_number);
        $stmt->execute();
        $stmt->close();
    } elseif ($action == 'reject') {
        // Update application status to 'Rejected'
        $stmt = $conn->prepare("UPDATE applications SET status='Rejected' WHERE application_id=?");
        $stmt->bind_param("i", $application_id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: manage_applications.php");
exit();
