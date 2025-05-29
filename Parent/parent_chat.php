<?php
session_start();
require '../Database/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Fetch user data
$user = getUserData($_SESSION['user_id']);
$title = "Parent Chat System";

// Fetch all users (instructors) for the chat
$sql = "SELECT id, username FROM users WHERE role_id = 2"; // Assuming role_id 2 is for instructors
$user_result = $conn->query($sql);

$content = "../Parent/parent_chat_content.php"; // Content file for the Parent chat
include '../setting/_Layout.php';
?>
