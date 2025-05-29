<?php
session_start();
require '../../Database/config.php';

$message = '';
$message_class = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_new') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role_id = $_POST['role_id'];
    $isActive = 1;

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($role_id)) {
        $message = 'All fields are required.';
        $message_class = 'alert-danger';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = 'Email is already registered.';
            $message_class = 'alert-danger';
        } else {
            $stmt->close();

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role_id, isActive) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssii", $username, $email, $password, $role_id, $isActive);
            if ($stmt->execute()) {
                $message = 'Registration successful!';
                $message_class = 'alert-success';
            } else {
                $message = 'Registration failed. Please try again.';
                $message_class = 'alert-danger';
            }
            $stmt->close();
        }
    }

    header("Location: ../user.php");
    exit;
}
?>