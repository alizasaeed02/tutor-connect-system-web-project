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

$title = "Chat System";

// Fetch user data with roles
$user_id = $_SESSION['user_id']; // Assuming you have the user ID in session


// Include the layout for the page
$content = "../Administrator/chating_system_content.php"; // Updated to new content file
include '../setting/_Layout.php';
?>
